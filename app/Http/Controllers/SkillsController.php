<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Skill;

class SkillsController extends Controller
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

        $skills = $class->skills;

        return view('skills.index', compact('class', 'skills'));
    }

    public function get($code) {
            $class = Classroom::where('code', $code)->firstOrFail();
            $this->authorize('view', $class);
            
            $array = preg_grep('~\.(png)$~', scandir(public_path() . '/img/skills/t1'));
            $images[0]['images'] = $array;
            $images[0]['name'] = "t1";
            $array = preg_grep('~\.(png)$~', scandir(public_path() . '/img/skills/t2'));
            $images[1]['images'] = $array;
            $images[1]['name'] = "t2";
            $array = preg_grep('~\.(png)$~', scandir(public_path() . '/img/skills/t3'));
            $images[2]['images'] = $array;
            $images[2]['name'] = "t3";
            return $images;
    }

    /* Active types:
        - Ask a question (yes or not) to the teacher in an exam.
        - Heal.
        - Heal group.
        - Heal everybody.
        - Steal random student money.
        - Steal random xp.
        - Undo last lose (50% rate).
    */

    /* Passive types:
        - Health individual.
        - Health group.
        - Health everybody.
        - Protection. (rate 50%)
        - Protection against steals (rate 70%).
        - Carry 1 more card.
    */

    public function useActive() {
    }



    // public function update($code) {
    //     $class = Classroom::where('code', $code)->firstOrFail();
    //     $this->authorize('update', $class);
    
    //     $data = request()->validate([
    //         'monster.id' => ['numeric'],
    //         'monster.name' => ['required', 'string'],
    //         'monster.image' => ['required', 'string'],
    //         'monster.hp' => ['numeric', 'required'],
    //         'monster.reward_xp' => ['numeric', 'required'],
    //         'monster.reward_gold' => ['numeric', 'required'],
    
    //     ]);

    //     $data['monster']['hp'] = max($data['monster']['hp'], 0); 
    //     $data['monster']['hp'] = min($data['monster']['hp'], 100); 

    //     $monster = Monster::find($data['monster']['id']);
    //     if($monster->classroom_id != $class->id)
    //         abort(403, 'What are you trying? :(');
        
    //     $monster->update($data['monster']);
    // }

    // public function battle() {
    //     $monster = Monster::findOrFail(request()->id);
    //     $class = Classroom::findOrFail($monster->classroom_id);
    //     $this->authorize('update', $class);

    //     $monster->update([
    //         'hp' => max(0 , $monster->hp + request()->value), 
    //     ]);

    // }

    public function store($code) {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'skill.name' => ['required', 'string'],
            'skill.description' => ['nullable', 'string'],
            'skill.icon' => ['required', 'string'],
            'skill.type' => ['numeric', 'required'],
            'skill.properties' => ['json', 'nullable'],
        ]);

        $data['skill']['classroom_id'] = $class->id;
        return Skill::create($data['skill']);
    }



    // public function destroy($id) {

    //     $monster = Monster::where('id', '=', $id)->first();
    //     $class = Classroom::where('id', '=', $monster->classroom_id)->first();
    //     $this->authorize('update', $class);
    //     try {
    //         $monster->delete();
    //     } catch (\Throwable $th) {
    //         return ['error' => $th];
    //     }
    //     return 1;

    // }
}
