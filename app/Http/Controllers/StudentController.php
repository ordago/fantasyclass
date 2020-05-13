<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classroom;
use App\Http\Classes\Queries;
use App\User;
use TaylorNetwork\UsernameGenerator\Generator;



class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function create($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        session()->flash('classroom', $class->id);
        return view('students.create', compact('class'));
    }

    public function store(Request $request) {
        dd(session()->get('classroom'));
        

    }

    public function generateUsername(Request $request) {
        
        $email = $request->email;
        // If the user is registered, return their username
        $username = User::select('username')->where('email', $email)->first();
        if($username) {
            return $username->username;
        }

        // Generate new username based on previous coincidents usernames
        $generator = new Generator();
        $username = $generator->generate($request->name);
        $userRows  = User::whereRaw("username REGEXP '^{$username}([0-9]*)?$'")->get();
        $countUser = count($userRows) + 1;

        return ($countUser > 1) ? "{$username}{$countUser}" : $username;
    }

}
