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
        $this->authorize('view', $class);
        $behaviours = $class->behaviours;
        return view('behaviours.index', compact('behaviours', 'class'));
    }

    // Add default cards
    public function importDefault($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        foreach (Behaviour::whereNull('classroom_id')->get() as $behaviour) {

            $newBehaviour = $behaviour->replicate();
            $class->cards()->save($newBehaviour);
        }
        return redirect('/classroom/' . $code . '/behaviours');
    }

    public function create($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        return view('behaviours.create', compact('class'));
    }

    public function show($code, $id) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $behaviour = Behaviour::where('id', '=', $id)
        ->where('classroom_id', "=", $class->id)
        ->firstOrFail();
        return view('behaviours.create', compact('class', 'behaviour'));
    }
    
    public function update($behaviour) {
        $behaviour = Behaviour::findOrFail($behaviour);
        $class = Classroom::where('id', '=', $behaviour->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
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
        $this->authorize('update', $class);
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
            $behaviour = Behaviour::where('id', '=', $id)->first();
            $class = Classroom::where('id', $behaviour->classroom_id)->firstOrFail();
            $this->authorize('update', $class);
            try {
            $behaviour->delete();
        } catch (\Throwable $th) {
            return [ 'error' => $th];
        }
        return 1;
    }
}
