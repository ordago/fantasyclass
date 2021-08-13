<?php

namespace App\Http\Controllers;

use App\Behaviour;
use Illuminate\Http\Request;
use App\Classroom;
use App\ClassroomUser;
use App\Collection;
use App\Equipment;
use App\Mail\RegisterStudent;
use App\Pet;
use App\Student;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use TaylorNetwork\UsernameGenerator\Generator;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function create($code, $flag = 0)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        session()->put('classroom', $class->id);
        $modalVisible = 0;
        if ($flag)
            $modalVisible = 1;

        return view('students.create', compact('class', 'modalVisible'));
    }

    public function showAsStudent()
    {
        $data = request()->validate([
            'id' => ['numeric', 'required'],
        ]);
        $student = Student::find($data['id']);
        $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        session()->put('bypass_student', $student->id);
        return '/classroom/show/' . $class->code;
    }

    public function store(Request $request)
    {
        $class = Classroom::where('id', '=', session()->pull('classroom'))->firstOrFail();
        $this->authorize('update', $class);
        $classId = $class->id;
        if (!$classId)
            return false;
        foreach ($request->students as $student) {
            $pass = '';
            if (strlen($student['name']) < 4)
                return false;
            if (isset($student['email']) && $student['username']) {
                $id = User::select('id')
                    ->where('email', $student['email'])
                    ->where('username', $student['username'])
                    ->first()['id'];
            } else {
                $verified = null;

                if (!isset($student['email'])) {
                    $verified = now();
                    $mail = null;
                } else $mail = $student['email'];
                $pass = strtolower(Str::random(5));
                $user = User::create([
                    'name' => $student['name'],
                    'username' => $this->generateUsername($student['name']),
                    'email' => $mail,
                    'email_verified_at' => $verified,
                    'password' => Hash::make($pass),
                    'is_student' => 1,
                    'locale' => auth()->user()->locale,
                ]);
                $id = $user->id;
                if (isset($student['email'])) {
                    Mail::to($student['email'])->send(new RegisterStudent($user, $pass));
                    $user->sendEmailVerificationNotification();
                }
            }
            try {
                $tmp = ClassroomUser::create([
                    'user_id' => $id,
                    'classroom_id' => $classId,
                    'role' => 0,
                ]);
            } catch (\Throwable $th) {
                session()->put('classroom', $classId);
                if (!isset($error))
                    $error = [];
                array_push($error, $student['name'] . " already exists in this classroom");
                continue;
            }

            // Get the new insertion id (another way? :/)
            $cuid = ClassroomUser::select('id')
                ->where('user_id', '=', $id)
                ->where('classroom_id', '=', $classId)
                ->where('role', '=', 0)
                ->get()
                ->first();

            if (!$class->characterTheme) {
                $charId = 0;
            } else {
                $charId = $class->characterTheme->characters->random(1)->first()->id;
            }

            // Create the student properties
            $student = Student::create([
                'classroom_user_id' => $cuid->id,
                'name' => $student['name'],
                'character_id' => $charId,
                'password_plain' => $pass,
                'google_uid' => $student['google_uid'],
                'google_course' => $student['google_course'],
            ]);

            if ($class->characterTheme) {
                // Assign basic equipment        
                $student->setBasicEquipment();
            }
        }
        if (isset($error) && count($error))
            return $error;
    }

    public function getStudent($id)
    {
        $student = Student::where('id', '=', $id)->with('equipment', 'skills', 'character', 'groups', 'pets', 'classroom')->first();
        $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        $student->append('numcards');
        return json_encode($student);
    }

    public function generateUsername($name)
    {
        $generator = new Generator();
        $username = $generator->generate($name);
        $userRows  = User::whereRaw("username REGEXP '^{$username}([0-9]*)?$'")->get();
        $countUser = count($userRows) + 1;

        return ($countUser > 1) ? "{$username}{$countUser}" : $username;
    }

    public function destroy($code, $stdId)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $student = Student::findOrFail($stdId);
        if ($student->classroom->classroom_id != $class->id)
            abort(403);

        $student->classroom()->delete();
        $student->delete();
    }

    public static function getRandomStudent($class)
    {

        return $class->students()->where('hidden', '=', 0)->inRandomOrder()->first();
    }

    public function addBehaviour()
    {
        $data = request()->all();
        $student = Student::where('id', '=', $data['id'])->first();

        $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
        $this->authorize('update', $class);

        return $student->addBehaviour($data['behaviour']);
    }

    public function assignPet($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'pet' => ['numeric', 'required'],
            'student' => ['numeric', 'required'],
        ]);

        $student = Student::findOrFail($data['student']);
        if ($class->id != $student->classroom->classroom_id)
            abort(403);

        if ($student->hp == 0)
            return false;

        $pet = Pet::where('id', $data['pet'])->where('classroom_id', $class->id)->firstOrFail();
        $student->pets()->sync([]);
        $student->pets()->sync([$pet->id]);

        return [
            "message" => " " . __('success_error.equipment_success'),
            "icon" => "check",
            "type" => "success",
            "pets" => $student->fresh()->pets,
            "boost" => $student->fresh()->getBoost(),
        ];
    }

    public function show($code, $id)
    {
        $student = Student::where('id', $id)->with(['equipment', 'pets', 'character', 'skills', 'badges', 'classroom', 'behaviours', 'logEntries', 'items', 'grades.tags'])->first();

        if ($student->classroom->classroom->code != $code)
            abort(404);
        $admin = true;
        $class = Classroom::where('code', $code)->with('pets', 'collections.collectionables', 'badges', 'theme', 'characterTheme.characters')->firstOrFail();
        $this->authorize('view', $class);

        $items = DB::table('students')
            ->crossJoin('items')
            ->where('items.classroom_id', '=', $class->id)
            ->where('students.id', '=', $student->id)
            ->select('*')
            ->leftJoin('item_student', function ($join) use ($student) {
                $join->on('items.id', '=', 'item_student.item_id')
                    ->where('item_student.student_id', '=', $student->id);
            })
            ->selectRaw('students.id, items.id, icon, IFNULL(item_student.count, 0) as count')
            ->get();

        $challenges = ClassroomsStudentController::getChallenges($student, $class, true);

        $cards = $student->cards;
        $student->append('boost');
        $student->load('blogs');
        $student->append('numcards');
        $student->load('collections');
        $student->load('collectionables');
        $student->append('blogsp');

        foreach ($student->getAutomaticBadges() as $badge) {
            $student->badges->push($badge);
        }

        $allcards = $class->cards->sortBy('type');

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $grades = collect();
        $grades->push(["namegroup" => __('evaluation.first'), "icon" => 'fas fa-chart-line', "evaluation" => EvaluationController::individualReport($class, [$student], null)]);
        foreach ($class->evalgroups as $evalg) {
            $grades->push(["namegroup" => $evalg->name, "icon" => $evalg->icon, "evaluation" => EvaluationController::individualReport($class, [$student], $evalg)]);
        }
        $evaluation[0] = $grades;
        $settings = EvaluationController::getEvalSettings($class->id);
        $settings['disable_your_adventure'] = settings()->get('disable_your_adventure', 0);
        $settings['skill_price'] = settings()->get('skill_price', 600);

        $eq0 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 0)->get();
        $eq1 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 1)->get();
        $eq2 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 2)->get();
        $eq3 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 3)->get();

        $shop = [
            'eq0' => json_encode($eq0),
            'eq1' => json_encode($eq1),
            'eq2' => json_encode($eq2),
            'eq3' => json_encode($eq3),
            'multiplier1' => (float) settings()->get('shop_multiplier_1', 1),
            'multiplier2' => (float) settings()->get('shop_multiplier_2', 1),
            'multiplier3' => (float) settings()->get('shop_multiplier_3', 1),
        ];


        return view('students.show', compact('student', 'shop', 'class', 'admin', 'items', 'challenges', 'cards', 'evaluation', 'settings', 'allcards'));
    }

    public static function getIndividualReport($id, $class)
    {
        $student = Student::findOrFail($id);
        $student->load('badges', 'behaviours', 'grades', 'items', 'behaviours', 'challenges', 'questions', 'grades',);
        if ($student->classroom->classroom_id != $class->id)
            abort(403);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $grades = collect();
        $grades->push(["namegroup" => __('evaluation.first'), "icon" => 'fas fa-chart-line', "evaluation" => EvaluationController::individualReport($class, [$student], null)]);
        foreach ($class->evalgroups as $evalg) {
            $grades->push(["namegroup" => $evalg->name, "icon" => $evalg->icon, "evaluation" => EvaluationController::individualReport($class, [$student], $evalg)]);
        }
        $settings = EvaluationController::getEvalSettings($class->id);
        $student->classSettings = $settings;
        $student->evaluation = $grades;
        return $student;
    }

    public function getStudentReport($code, $id)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $student = StudentController::getIndividualReport($id, $class);
        return view('students.report', compact('student', 'class'));
    }

    public function getStudentsReport($code)
    {
        $students = [];
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        if ($class->students->count() < env('MIX_MAX_STUDENTS')) {
            foreach ($class->students as $student) {
                array_push($students, StudentController::getIndividualReport($student->id, $class));
            }
            return view('students.reportclass', compact('students', 'class'));
        } else abort(403, 'Exceded number of students');
    }

    public function assignEquipment($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $student = Student::findOrFail(request()->student);
        if ($student->classroom->classroom_id != $class->id || $student->hp <= 0)
            abort(403);

        $new = Equipment::where('id', '=', request()->new)->firstOrFail();

        // $old = Equipment::where('id', '=', request()->old)->firstOrFail();
        $old = DB::table('equipment_student')
            ->join('equipment', 'equipment.id', 'equipment_student.equipment_id')
            ->where('equipment_student.student_id', '=', $student->id)
            ->where('equipment.type', '=', $new->type)
            ->select('*')
            ->first();

        $student->equipment()->detach($old->id);
        $student->equipment()->attach($new->id);
        return [
            "message" => " " . __('success_error.equipment_success'),
            "icon" => "check",
            "type" => "success",
            "equipment" => $student->fresh()->equipment,
            "boost" => $student->fresh()->getBoost(),
        ];
    }


    public function deleteLog(Request $request)
    {

        $student = Student::findOrFail($request->student);
        $class = Classroom::where('id', $student->classroom->classroom->id)->first();
        $this->authorize('update', $class);

        $item = DB::table("log_entries")
            ->where('type', $request->row['type'])
            ->where('student_id', '=', $student->id)
            ->where('value', '>=', $request->row['value'])
            ->where('created_at', '>=', $request->date)
            ->orderBy('created_at')
            ->take(1)
            ->delete();

        $student->setProperty($request->row['type'], $request->row['value'] * -1, false, null, true);
    }
    public function deleteBehaviour(Request $request)
    {

        $student = Student::findOrFail($request->student);
        $class = Classroom::where('id', $student->classroom->classroom->id)->first();
        $this->authorize('update', $class);

        DB::table($student->behaviours()->getTable())
            ->where('behaviour_id', $request->row['id'])
            ->where('student_id', '=', $student->id)
            ->where('created_at', '>=', $request->date)
            ->orderBy('created_at')
            ->take(1)
            ->delete();

        return $student->fresh()->behaviours;
    }
    public function updateName(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $class = Classroom::where('id', $student->classroom->classroom->id)->first();
        $this->authorize('update', $class);

        $data = $request->validate([
            'name' => ['string', 'required', 'min:4']
        ]);
        $student->update(['name' => $data['name']]);
    }
    public function update(Request $request)
    {
        if ($request->action == "pay") {
            $info = session()->pull('pending_gold');
            $student = Student::findOrFail($info['student']);
            $gold = $info['gold'];
            if ($gold > $student->gold) {
                return ['type' => 'error', 'message' => __('success_error.shop_failed_money')];
            }
            return $student->setProperty('gold', $info['gold'] * -1, true, $request->type);
        } else if ($request->id) {
            $student = Student::findOrFail($request->id);
            $class = Classroom::where('id', $student->classroom->classroom->id)->first();
            $this->authorize('update', $class);
            if ($request->card_id) {
                $student->cards()->attach($request->card_id);
                return true;
            } else if ($request->prop == "object") {
                $studentItem = $student->items->where('id', $request->value)->first();
                if ($studentItem)
                    $count = $studentItem->pivot->count + 1;
                else $count = 1;
                $student->items()->sync([$request->value => ['count' => $count]], false);
            } else {
                return $student->setProperty($request->prop, $request->value, true, $request->type);
            }
        } else {
            $class = Classroom::where('code', $request->code)->first();
            $this->authorize('update', $class);
            foreach ($class->students as $student) {
                $student->setProperty($request->prop, $request->value, true, $request->type);
            }
        }
    }

    public function toggle()
    {
        $student = Student::findOrFail(request()->id);
        $class = Classroom::where('id', $student->classroom->classroom->id)->first();
        $this->authorize('update', $class);
        $student->update([request()->prop => (($student->hidden + 1) % 2)]);
    }

    public function changeCharacter($code)
    {
        $student = Student::findOrFail(request()->id);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        if (isset(request()->mode) && isset(request()->mode) == 'student') {
            if ($student->classroom->user->user_id != auth()->user()->user_id) {
                abort(403);
            }
        } else {
            $this->authorize('update', $class);
        }
        $student->update(['character_id' => request()->character_id]);
        $student->setBasicEquipment();
    }

    public function getUsername(Request $request)
    {

        $email = $request->email;
        if (!$email)
            return false;

        // If the user is registered, return their username
        $username = User::select('username')->where('email', $email)->first();
        if ($username) {
            return $username->username;
        } else return false;
    }
}
