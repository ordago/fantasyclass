<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Skill;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

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

    public function index($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $skills = $class->skills;

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $settings['skill_price'] = settings()->get('skill_price', 600);
        $settings['skill_enabled'] = settings()->get('skill_enabled', 0);

        return view('skills.index', compact('class', 'skills', 'settings'));
    }

    public function get($code)
    {
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

    public function importDefault($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        // Active skills
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.question',
            'description' => 'skills.question_desc',
            'icon' => '/img/skills/t1/rpg-priest_active_12.png',
            'type' => 0,
            'properties' => [
                'type' => 'common',
            ],
        ]);
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.music',
            'description' => 'skills.music_desc',
            'icon' => '/img/skills/t1/skills_skill_icon_7.png',
            'type' => 0,
            'properties' => [
                'type' => 'common',
            ],
        ]);
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.heal_self',
            'description' => 'skills.heal_self_desc',
            'icon' => ' /img/skills/t1/rpg-priest_active_11.png',
            'type' => 0,
            'properties' => [
                'hp_min' => 20,
                'hp_max' => 40,
                'type' => 'heal_self',
            ],
        ]);
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.heal_group',
            'description' => 'skills.heal_group_desc',
            'icon' => ' /img/skills/t1/rpg-priest_active_2.png',
            'type' => 0,
            'properties' => [
                'hp_min' => 5,
                'hp_max' => 20,
                'type' => 'heal_group',
            ],
        ]);
        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.heal_classroom',
            'description' => 'skills.heal_classroom_desc',
            'icon' => ' /img/skills/t1/rpg-priest_active_3.png',
            'type' => 0,
            'properties' => [
                'hp_min' => 5,
                'hp_max' => 20,
                'type' => 'heal_classroom',
            ],
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.steal_money',
            'description' => 'skills.steal_money_desc',
            'icon' => ' /img/skills/t1/rpg-rogue_active12.png',
            'type' => 0,
            'properties' => [
                'money_min' => 200,
                'money_max' => 400,
                'users' => 3,
                'type' => 'steal_money',
            ],
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.steal_xp',
            'description' => 'skills.steal_xp_desc',
            'icon' => '/img/skills/t1/rpg-rogue_active10.png',
            'type' => 0,
            'properties' => [
                'xp_min' => 10,
                'xp_max' => 40,
                'users' => 3,
                'type' => 'steal_xp',
            ],
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.undo_action',
            'description' => 'skills.undo_action_desc',
            'icon' => '/img/skills/t1/game_skill_17.png',
            'type' => 0,
            'properties' => [
                'type' => 'undo_action',
            ],
        ]);

        // Passive

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.heal_passive',
            'description' => 'skills.heal_passive_desc',
            'icon' => '/img/skills/t1/skills_skill_icon_44.png',
            'type' => 1,
            'properties' => [
                'success' => 50,
                'hp_increment' => 50,
                'type' => 'heal_passive',
            ],
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.protection',
            'description' => 'skills.protection_desc',
            'icon' => '/img/skills/t1/rpg-knight_active6.png',
            'type' => 1,
            'properties' => [
                'success' => 15,
                'type' => 'protection',
            ],
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.protection',
            'description' => 'skills.protection_desc',
            'icon' => '/img/skills/t1/rpg-knight_active13.png',
            'type' => 1,
            'properties' => [
                'success' => 30,
                'type' => 'protection',
            ],
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.protection_steal',
            'description' => 'skills.protection_steal_desc',
            'icon' => '/img/skills/t1/rpg-mage_active12.png',
            'type' => 1,
            'properties' => [
                'success' => 70,
                'type' => 'protection_steal',
            ],
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.cards_name',
            'description' => 'skills.cards_desc',
            'icon' => '/img/skills/t1/rpg-rogue_active1.png',
            'type' => 1,
            'properties' => [
                'cards' => 1,
                'type' => 'cards',
            ],
        ]);

        Skill::create([
            'classroom_id' => $class->id,
            'name' => 'skills.protection_death',
            'description' => 'skills.protection_death_desc',
            'icon' => '/img/skills/t1/game_skill_32.png',
            'type' => 1,
            'properties' => [
                'success' => 90,
                'type' => 'protection_death',
            ],
        ]);

        return $class->fresh()->skills;
    }

    public function update($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'skill.id' => ['required', 'numeric'],
            'skill.name' => ['required', 'string'],
            'skill.description' => ['nullable', 'string'],
            'skill.icon' => ['required', 'string'],
            'skill.type' => ['numeric', 'required'],
            'skill.properties' => ['array', 'nullable'],
        ]);

        $skill = Skill::find($data['skill']['id']);
        if($skill->classroom_id != $class->id)
            abort(403, 'What are you trying? :(');

        $skill->update($data['skill']);
    }


    public static function undoAction($student)
    {

        $row = $student->logEntries()
            ->where('value', '<', 0)
            ->orderByDesc('created_at')
            ->first();

        $student->setProperty($row->type, $row->value * -1, true, 'skill', true);
        $row->delete();
    }

    public function store($code)
    {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'skill.name' => ['required', 'string'],
            'skill.description' => ['nullable', 'string'],
            'skill.icon' => ['required', 'string'],
            'skill.type' => ['numeric', 'required'],
            'skill.properties' => ['array', 'nullable'],
        ]);
        if (!isset($data['skill']['properties']))
            $data['skill']['properties'] = ['type' => 'common'];

        $data['skill']['classroom_id'] = $class->id;
        return Skill::create($data['skill']);
    }



    public function destroy($id)
    {

        $skill = Skill::where('id', '=', $id)->first();
        $class = Classroom::where('id', '=', $skill->classroom_id)->first();
        $this->authorize('update', $class);
        try {
            $skill->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }
}
