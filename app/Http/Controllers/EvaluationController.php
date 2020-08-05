<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Evaluable;
use App\Rubric;
use App\Tag;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $tags = Tag::where('classroom_id', $class->id)->get();
        $rubrics = Rubric::where('user_id', auth()->user()->id)->get();
        $lines = Evaluable::where('classroom_id', $class->id)->with('tags')->get();
        return view('evaluation.index', compact('class', 'tags', 'rubrics', 'lines'));
    }

    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'tags' => ['array', 'required'],
            'weights' => ['required'],
            'description' => ['required', 'string'],
            'type' => ['required', 'numeric'],
            'rubric' => ['nullable', 'numeric'],
            ]);

        $evaluable = Evaluable::create([
            'description' => $data['description'],
            'type' => $data['type'],
            'rubric_id' => $data['rubric'],
            'classroom_id' => $class->id,
        ]);

        foreach ($data['tags'] as $tag) {
            $evaluable->tags()->attach([
                $tag['id'] => ['weight' => $data['weights'][$tag['id']]],
            ]);
        }
    }
}
