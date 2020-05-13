<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Classroom;
use App\Http\Classes\Queries;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function create($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $bg = Queries::getBg($class->theme_id);
        session()->flash('classroom', $class->id);
        return view('students.create', compact('class', 'bg'));
    }

    public function store() {
        dd(session()->get('classroom'));
    }

}
