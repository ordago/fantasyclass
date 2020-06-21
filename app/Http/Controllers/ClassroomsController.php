<?php

namespace App\Http\Controllers;

use App\ChallengesGroup;
use App\Classroom;
use App\ClassroomUser;
use App\GoalThemes;
use App\Grouping;
use App\Theme;
use App\Item;
use App\QuestionBank;
use App\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClassroomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function reference($num)
    {

        $unique = strtolower(Str::random($num));
        $check = Classroom::where('code', $unique)->first();
        if ($check) {
            return $this->reference($num);
        }
        return $unique;
    }

    public function update($code)
    {
     
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'adventureName' => ['required', 'string', 'min:3', 'max:255'],
            'goalType' => ['required', 'integer'],
            'bgtheme' => ['required', 'integer'],
            'charTheme' => ['required', 'integer'],
        ]);

        $class->update([
            'name' => $data['name'],
            'adventure_name' => $data['adventureName'],
            'enrollment_code' => $this->reference(5),
            'character_theme' => $data['charTheme'],
            'theme_id' => $data['bgtheme'],
            'goal_type' => $data['goalType'],
        ]);

        return redirect('/classroom/'.$code);

    }
    public function store()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'adventureName' => ['required', 'string', 'min:3', 'max:255'],
            'goalType' => ['required', 'integer'],
            'bgtheme' => ['required', 'integer'],
            'charTheme' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return redirect('/classroom/create')
                ->withErrors($validator)
                ->withInput();
        }

        $classroom = Classroom::create([
            'name' => $data['name'],
            'adventure_name' => $data['adventureName'],
            'code' => $this->reference(8),
            'enrollment_code' => $this->reference(5),
            'character_theme' => $data['charTheme'],
            'theme_id' => $data['bgtheme'],
            'goal_type' => $data['goalType'],
        ]);

        // Assign basic items
        foreach (Item::whereNull('classroom_id')->get() as $item) {
            $newItem = $item->replicate();
            $classroom->cards()->save($newItem);
        }

        // Create default challenges group
        ChallengesGroup::create([
            'name' => 'General',
            'icon' => 'fas fa-home',
            'classroom_id' => $classroom->id,
        ]);

        // Create default grouping
        Grouping::create([
            'name' => 'General',
            'classroom_id' => $classroom->id,
        ]);

        auth()->user()->classrooms()->attach([
            $classroom->id => ['role' => 2],
        ]);

        return redirect('/classroom');
    }

    public function join($code)
    {
        $class = Classroom::where('enrollment_code', '=', $code)->firstOrFail();
        $id = auth()->user()->id;
        $classId = $class->id;
        try {
            ClassroomUser::create([
                'user_id' => $id,
                'classroom_id' => $classId,
                'role' => 0,
            ]);
        } catch (\Throwable $th) {
            return false;
        }

        // Get the new insertion id (another way? :/)
        $cuid = ClassroomUser::select('id')
            ->where('user_id', '=', $id)
            ->where('classroom_id', '=', $classId)
            ->where('role', '=', 0)
            ->get()
            ->first();

        // Create the student properties
        $student = Student::create([
            'classroom_user_id' => $cuid->id,
            'name' => auth()->user()->name,
            'character_id' => Classroom::findOrFail($classId)->characterTheme->characters->random(1)->first()->id,
        ]);

        // Assign basic equipment        
        $student->setBasicEquipment();
    }

    public function edit($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'behaviours')->firstOrFail();
        $this->authorize('view', $class);
        $goals = GoalThemes::All();
        $themes = Theme::All();
        return view('classrooms.create', compact('goals', 'themes', 'class'));
    }
    public function create()
    {
        $goals = GoalThemes::All();
        $themes = Theme::All();
        return view('classrooms.create', compact('goals', 'themes'));
    }

    public function index()
    {
        $user = auth()->user();
        return view('classrooms.index', compact('user'));
    }

    public function destroy($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);
        $class->delete();
        return "/classroom";
    }
    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'behaviours', 'grouping.groups')->firstOrFail();
        $this->authorize('view', $class);
        $students = $class->students()->with('equipment')->get();

        $pending = collect();
        foreach ($class->students as $student) {
            $cards = $student->cards->where('pivot.marked', ">" , 0);
            if($cards->count())
                $pending->add(['student' => $student, 'cards' => $cards]);
        }

        return view('classrooms.show', compact('class', 'students', 'pending'));
    }
}
