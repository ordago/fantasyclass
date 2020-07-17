<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Rubric;
use Illuminate\Http\Request;

class RubricController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);
        $rubrics = Rubric::where('user_id', auth()->user()->id)->get();

        return view('rubric.index', compact('class', 'rubrics'));

    }
    public function create($code) {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        return view('rubric.create', compact('class'));

    }
}
