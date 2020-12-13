<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Monster;
use Illuminate\Http\Request;

class MonsterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $monsters = $class->monsters;

        return view('monsters.index', compact('class', 'monsters'));
    }

    public function update($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);
    
        $data = request()->validate([
            'monster.id' => ['numeric'],
            'monster.name' => ['required', 'string'],
            'monster.image' => ['required', 'string'],
            'monster.hp' => ['numeric', 'required'],
            'monster.reward_xp' => ['numeric', 'required'],
            'monster.reward_gold' => ['numeric', 'required'],
    
        ]);

        $data['monster']['hp'] = max($data['monster']['hp'], 0); 
        $data['monster']['hp'] = min($data['monster']['hp'], 100); 

        $monster = Monster::find($data['monster']['id']);
        if($monster->classroom_id != $class->id)
            abort(403, 'What are you trying? :(');
        
        $monster->update($data['monster']);
    }

    public function battle() {
        $monster = Monster::findOrFail(request()->id);
        $class = Classroom::findOrFail($monster->classroom_id);
        $this->authorize('update', $class);

        $monster->update([
            'hp' => max(0 , $monster->hp + request()->value), 
        ]);

    }

    public function store($code) {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'monster.name' => ['required', 'string'],
            'monster.image' => ['required', 'string'],
            'monster.reward_xp' => ['numeric', 'required'],
            'monster.reward_gold' => ['numeric', 'required'],
        ]);
        $data['monster']['hp'] = 100;
        $data['monster']['classroom_id'] = $class->id;

        return Monster::create($data['monster']);

    }



    public function destroy($id) {

        $monster = Monster::where('id', '=', $id)->first();
        $class = Classroom::where('id', '=', $monster->classroom_id)->first();
        $this->authorize('update', $class);
        try {
            $monster->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;

    }
}
