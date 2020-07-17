<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

    
        $data = request()->validate([
            'short' => ['required', 'string', 'max:10'],
            'description' => ['required', 'string'],
            'percent' => ['required', 'numeric'],
        ]);

        return Tag::create([
            'short' => $data['short'],
            'description' => $data['description'],
            'percent' => $data['percent'],
            'classroom_id' => $class->id,
        ]);
    }


}
