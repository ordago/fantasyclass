<?php

namespace App\Http\Controllers;

use App\Behaviour;
use Illuminate\Http\Request;
use App\Classroom;
use App\ClassroomUser;
use App\Student;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use TaylorNetwork\UsernameGenerator\Generator;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function create($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        session()->put('classroom', $class->id);
        return view('students.create', compact('class'));
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
            if ($student['email'] && $student['username']) {
                $id = User::select('id')
                    ->where('email', $student['email'])
                    ->where('username', $student['username'])
                    ->first()['id'];
            } else {
                $verified = null;
                if (!$student['email']) {
                    $verified = now();
                }
                $pass = strtolower(Str::random(5));
                $user = User::create([
                    'name' => $student['name'],
                    'username' => $this->generateUsername($student['name']),
                    'email' => $student['email'],
                    'email_verified_at' => $verified,
                    'password' => Hash::make($pass),
                    'is_student' => 1,
                    'locale' => auth()->user()->locale,
                ]);
                $id = $user->id;
                if ($student['email'])
                    $user->sendEmailVerificationNotification();
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
                array_push($error, $student['name'] . " can't be created");
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
            ]);

            if ($class->characterTheme) {
                // Assign basic equipment        
                $student->setBasicEquipment();
            }
        }
        if (isset($error) && count($error))
            return $error;
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

        return $class->students->where('hidden', 0)->random(1)->first();
    }

    public function addBehaviour()
    {
        $data = request()->all();
        $student = Student::where('id', '=', $data['id'])->first();

        $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
        $this->authorize('update', $class);

        return $student->addBehaviour($data['behaviour']);
    }

    public function show($code, $id)
    {
        $student = Student::where('id', $id)->with(['equipment', 'badges', 'classroom', 'behaviours', 'logEntries', 'items', 'grades'])->first();

        if ($student->classroom->classroom->code != $code)
            abort(404);
        $admin = true;
        $class = Classroom::where('code', $code)->with('badges', 'theme', 'characterTheme.characters')->firstOrFail();
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

        $challenges = DB::table('students')
            ->crossJoin('challenges')
            ->where('challenges.is_conquer', '=', 1)
            ->whereIn('challenges.id', function ($query) use ($class) {
                $query->select('challenges.id')
                    ->from('challenges')
                    ->join('challenges_groups', 'challenges_groups.id', 'challenges.challenges_group_id')
                    ->where('challenges_groups.classroom_id', '=', $class->id)
                    ->get();
            })
            ->where('students.id', '=', $student->id)
            ->select('*')
            ->leftJoin('challenge_student', function ($join) use ($student) {
                $join->on('challenges.id', '=', 'challenge_student.challenge_id')
                    ->where('challenge_student.student_id', '=', $student->id);
            })
            ->select('*')
            ->get();

        $cards = $student->cards;
        $student->append('boost');

        $evaluation[0] = EvaluationController::individualReport($class, $student);
        $settings = EvaluationController::getEvalSettings($class->id);

        return view('students.show', compact('student', 'class', 'admin', 'items', 'challenges', 'cards', 'evaluation', 'settings'));
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
        // ->get();

        $student->setProperty($request->row['type'], $request->row['value'] * -1, false, true);
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
        // ->get();

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
        if ($request->id) {
            $student = Student::findOrFail($request->id);
            $class = Classroom::where('id', $student->classroom->classroom->id)->first();
            $this->authorize('update', $class);
            if ($request->card_id) {
                $student->cards()->attach($request->card_id);
                return true;
            } else {
                return $student->setProperty($request->prop, $request->value, true);
            }
        } else {
            $class = Classroom::where('code', $request->code)->first();
            $this->authorize('update', $class);
            foreach ($class->students as $student) {
                $student->setProperty($request->prop, $request->value, true);
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
