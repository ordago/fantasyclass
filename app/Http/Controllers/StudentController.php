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
        session()->put('classroom', $class->id);
        return view('students.create', compact('class'));
    }
    
    public function store(Request $request) 
    {
        $classId = session()->pull('classroom');
        if(!$classId)
            return false;
        foreach ($request->students as $student) {
            $pass = '';
            if($student['email'] && $student['username']) {
                $id = User::select('id')
                        ->where('email', $student['email'])
                        ->where('username', $student['username'])
                        ->first()['id'];
            } else {
                $pass = strtolower(Str::random(5));
                $user = User::create([
                    'name' => $student['name'],
                    'username' => $this->generateUsername($student['name']),
                    'email' => $student['email'],
                    'email_verified_at' => now(),
                    'password' => Hash::make($pass),
                    'is_student' => 1,
                ]);
                $id = $user->id;
            }
            try {
                $tmp = ClassroomUser::create([
                    'user_id' => $id,
                    'classroom_id' => $classId,
                    'role' => 0,
                ]);
            } catch (\Throwable $th) {
                session()->put('classroom', $classId);
                if(!isset($error))
                    $error = [];
                array_push($error, $student['name']." can't be created");
                continue;
            }
            // Attach user to classroom as student

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
                'character_id' => Classroom::find($classId)->characterTheme->characters->random(1)->first()->id,
                'password_plain' => $pass,
            ]);
            
            // Assign basic equipment        
            $student->setBasicEquipment();        
        }
        if(isset($error) && count($error))
            return $error;
    }

    public function generateUsername($name) {
        $generator = new Generator();
        $username = $generator->generate($name);
        $userRows  = User::whereRaw("username REGEXP '^{$username}([0-9]*)?$'")->get();
        $countUser = count($userRows) + 1;

        return ($countUser > 1) ? "{$username}{$countUser}" : $username;
    }

    public function addBehaviour() {
        $data = request()->all();
        $student = Student::where('id', '=', $data['id'])->first();
    
        $behaviour = Behaviour::findOrFail($data['behaviour']);
        $student->behaviours()->attach($data['behaviour']);
        $valHp = $student->setProperty('hp', $behaviour->hp);
        $valXp = $student->setProperty('xp', $behaviour->xp);
        $valGold = $student->setProperty('gold', $behaviour->gold);

        return[
            'hp' => $valHp,
            'xp' => $valXp,
            'gold' => $valGold,
            'level' => $student->getLevelAttribute(),
        ];
        
    }

    public function index($code, $id) {
        $student = Student::where('id', $id)->with(['equipment', 'classroom', 'behaviours', 'logEntries', 'items'])->first();
        
        if($student->classroom->classroom->code != $code)
            abort(404);
        $admin = true;  
        $class = Classroom::where('code', $code)->with('theme', 'characterTheme.characters')->firstOrFail();

        $items = DB::table('students')
        ->crossJoin('items')
        ->where('items.classroom_id', '=', $class->id)
        ->where('students.id', '=', $student->id)
        ->select('*')
        ->leftJoin('item_student', function($join) use ($student) {
            $join->on('items.id', '=', 'item_student.item_id')
                    ->where('item_student.student_id', '=', $student->id);
        })
        ->selectRaw('students.id, items.id, icon, IFNULL(item_student.count, 0) as count')
        ->get();

        return view('students.show', compact('student', 'class', 'admin', 'items'));
    }

    public function update(Request $request) {
        $student = Student::findOrFail($request->id);
        LogEntry::create([
            'type' => $request->prop,
            'value' => $request->value,
            'student_id' => $student->id,
        ]);
        return $student->setProperty($request->prop, $request->value);
    }

    public function changeCharacter($code) {
        $student = Student::findOrFail(request()->id);
        $student->update(['character_id' => request()->character_id]);
        $student->setBasicEquipment();
    }

    public function getUsername(Request $request) 
    {
        
        $email = $request->email;
        if(!$email)
            return false;

        // If the user is registered, return their username
        $username = User::select('username')->where('email', $email)->first();
        if($username) {
            return $username->username;
        } 
        
        else return false;
       
    }

}
