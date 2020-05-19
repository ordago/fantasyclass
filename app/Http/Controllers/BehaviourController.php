<?php

namespace App\Http\Controllers;

use App\Behaviour;
use App\Classroom;
use Illuminate\Http\Request;

class BehaviourController extends Controller
{
    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $behaviours = $class->behaviours;
        return view('behaviours.index', compact('behaviours', 'class'));
    }

    public function create($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        return view('behaviours.create', compact('class'));
    }
    
    public function store($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        
        $data = request()->validate([
            'icon' => ['required', 'string'],
            'name' => ['required', 'string'],
            'custom_text' => ['nullable', 'string'],
            'xp' => ['required', 'numeric'],
            'hp' => ['required', 'numeric'],
            'gold' => ['required', 'numeric'],
        ]);

        $behaviour = Behaviour::create($data);
        $class->behaviours->save($behaviour);
        
    }
}
