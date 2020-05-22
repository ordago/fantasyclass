<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\GoalThemes;
use App\Theme;
use App\Http\Classes\Queries;
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

    public function store() 
    {

        $data = request()->all();
        
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
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
            'enrollment_code' => $this->reference(4),
            'character_theme' => $data['charTheme'],
            'theme_id' => $data['bgtheme'],
            'goal_type' => $data['goalType'],
        ]);

        auth()->user()->classrooms()->attach([
            $classroom->id => ['role' => 2],
        ]);
        
        return redirect('/classroom');

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
    
    public function show($code) 
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $bg = Theme::getBg($class->theme->id);
        $students = $class->students()->with('equipment')->get();
        return view('classrooms.show', compact('class', 'students'));
    }
}
