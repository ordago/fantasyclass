<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Rules;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function default()
    {
        return file_get_contents(public_path() . '/rules/' . request()->lang . '.txt');
    }

    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $rules = Rules::where('classroom_id', $class->id)->first();
        return view('rules.show', compact('class', 'rules'));

    }
    public function update($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $rules = Rules::where('classroom_id', $class->id)->first();
        if ($rules) {
            $rules->update(['content' => request()->content]);
        } else {
            Rules::create([
                'classroom_id' => $class->id,
                'content' => request()->content,
            ]);
        }
    }
}
