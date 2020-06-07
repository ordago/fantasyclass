<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\ClassroomUser;
use App\Student;
use Illuminate\Http\Request;

class ClassroomsStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function show($code) {
        $class = Classroom::where('code', '=', $code)->with('theme', 'characterTheme.characters')->firstOrFail();
        $admin = false;        
        $student = Student::where('id', '=', auth()->user()->classrooms
        ->where('pivot.classroom_id', '=', $class->id)
        ->where('pivot.role', '=', 0)
        ->first()
        ->pivot
        ->student->id)->with(['equipment', 'classroom', 'behaviours', 'logEntries', 'items'])->first();
        return view('studentsview.show', compact('student', 'class', 'admin'));
        

    }
}
