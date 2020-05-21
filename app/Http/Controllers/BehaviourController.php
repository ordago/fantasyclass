<?php

namespace App\Http\Controllers;

use App\Behaviour;
use App\Classroom;
use Illuminate\Http\Request;

class BehaviourController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $behaviours = $class->behaviours;
        return view('behaviours.index', compact('behaviours', 'class'));
    }

    public function create($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        return view('behaviours.create', compact('class'));
    }

    public function show($code, $id) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $behaviour = Behaviour::where('id', '=', $id)
                    ->where('classroom_id', "=", $class->id)
                    ->firstOrFail();
        return view('behaviours.create', compact('class', 'behaviour'));
    }

    public function update($code, $behaviour) {
        try {
            $behaviour = Behaviour::findOrFail($behaviour);
            $behaviour->update($this->validateFormat(request()));
            return [
                    "message" => __('success_error.update_success'),
                    "type" => "success",
                    "icon" => "check"
            ];
            
        } catch (\Throwable $th) {
            return [
                    "message" => __('success_error.error'),
                    "type" => "times",
                    "type" => "error"
            ];
            return $th;
        }
        
    }
    
    public function store($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        
        $data = $this->validateFormat(request());

        $behaviour = Behaviour::create($data);
        $class->behaviours()->save($behaviour);
        return redirect('/classroom/'.$code.'/behaviours');
        
    }

    public function validateFormat($request) {
        return $request->validate([
            'icon' => ['required', 'string'],
            'name' => ['required', 'string'],
            'custom_text' => ['nullable', 'string'],
            'xp' => ['required', 'numeric'],
            'hp' => ['required', 'numeric'],
            'gold' => ['required', 'numeric'],
        ]);
    }

    public function destroy($id) {
        try {
            Behaviour::destroy($id);
        } catch (\Throwable $th) {
            return [ 'error' => $th];
        }
        return 1;
    }
}
