<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Rubric;
use App\Tag;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $tags = Tag::where('classroom_id', $class->id)->get();
        $rubrics = Rubric::where('user_id', auth()->user()->id)->get();

        return view('evaluation.index', compact('class', 'tags', 'rubrics'));
    }

    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

    
        $data = request()->validate([
            'tags' => ['array', 'required'],
            'weights' => ['required'],
            'description' => ['required', 'string'],
        ]);

        // return Tag::create([
        //     'short' => $data['short'],
        //     'description' => $data['description'],
        //     'percent' => $data['percent'],
        //     'classroom_id' => $class->id,
        // ]);
    }

}
