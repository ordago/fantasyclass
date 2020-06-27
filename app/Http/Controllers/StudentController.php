<?php

namespace App\Http\Controllers;

use App\Behaviour;
use Illuminate\Http\Request;
use App\Classroom;
use App\ClassroomUser;
use App\LogEntry;
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
            if ($student['email'] && $student['username']) {
                $id = User::select('id')
                    ->where('email', $student['email'])
                    ->where('username', $student['username'])
                    ->first()['id'];
            } else {
                $verified = null;
                if(!$student['email']) {
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
                if($student['email'])
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


            // Create the student properties
            $student = Student::create([
                'classroom_user_id' => $cuid->id,
                'name' => $student['name'],
                'character_id' => Classroom::findOrFail($classId)->characterTheme->characters->random(1)->first()->id,
                'password_plain' => $pass,
            ]);

            // Assign basic equipment        
            $student->setBasicEquipment();
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

    public static function getRandomStudent($class) {

        return $class->students->random(1)->first();

    }

    public function addBehaviour()
    {
        $data = request()->all();
        $student = Student::where('id', '=', $data['id'])->first();
        
        $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
        $this->authorize('update', $class);

        $behaviour = Behaviour::findOrFail($data['behaviour']);
        $behaviour->update(['count_number' => $behaviour->count_number + 1]);
        $student->behaviours()->attach($data['behaviour']);
        $valHp = $student->setProperty('hp', $behaviour->hp);
        $valXp = $student->setProperty('xp', $behaviour->xp);
        $valGold = $student->setProperty('gold', $behaviour->gold);

        return [
            'hp' => $valHp,
            'xp' => $valXp,
            'gold' => $valGold,
            'level' => $student->getLevelAttribute(),
        ];
    }

    public function show($code, $id)
    {
        $student = Student::where('id', $id)->with(['equipment', 'classroom', 'behaviours', 'logEntries', 'items'])->first();

        if ($student->classroom->classroom->code != $code)
            abort(404);
        $admin = true;
        $class = Classroom::where('code', $code)->with('theme', 'characterTheme.characters')->firstOrFail();
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
            ->whereIn('challenges.id', function($query) use ($class){
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

        return view('students.show', compact('student', 'class', 'admin', 'items', 'challenges', 'cards'));
    }

    public function update(Request $request)
    {
        if($request->id) {
            $student = Student::findOrFail($request->id);
            $class = Classroom::where('id', $student->classroom->classroom->id)->first();
            $this->authorize('update', $class);
            if($request->card_id) {
                $student->cards()->attach($request->card_id);
                return true;
            } else {
                LogEntry::create([
                    'type' => $request->prop,
                    'value' => $request->value,
                    'student_id' => $student->id,
                    ]);
                    return $student->setProperty($request->prop, $request->value);
            }
            } else {
                $class = Classroom::where('code', $request->code)->first();
                $this->authorize('update', $class);
                foreach ($class->students as $student) {
                    $student->setProperty($request->prop, $request->value);
                }
                
            }
    }

    public function changeCharacter($code)
    {
        $student = Student::findOrFail(request()->id);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
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
