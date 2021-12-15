<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'name' => ['required', 'string', 'max:100'],
            'class' => ['required', 'string', 'max:10'],
        ]);

        Subject::create([
            'name' => $data['name'],
            'classroom_id' => $class->id,
            'class' => $data['class'],
        ]);
        return $class->fresh()->subjects;
    }
}
