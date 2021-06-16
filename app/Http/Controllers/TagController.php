<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Tag;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);
        $class = Classroom::where('id', $tag->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        $tag->delete();
    }

    public function update($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'short' => ['required', 'string', 'max:15'],
            'description' => ['required', 'string'],
            'percent' => ['required', 'numeric'],
            'id' => ['required', 'numeric'],
            'evaluables_group_id' => ['nullable', 'numeric']
        ]);

        $tag = Tag::where('id', $data['id'])->where('classroom_id', $class->id)->firstOrFail();
        $tag->update($data);

    }
    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'short' => ['required', 'string', 'max:15'],
            'description' => ['required', 'string'],
            'percent' => ['required', 'numeric'],
            'evaluables_group_id' => ['required', 'numeric']
        ]);

        return Tag::create([
            'short' => $data['short'],
            'description' => $data['description'],
            'percent' => $data['percent'],
            'classroom_id' => $class->id,
            'evaluables_group_id' => $data['evaluables_group_id']
        ]);
    }
}
