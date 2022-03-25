<?php

namespace App\Http\Controllers;

use App\Battle;
use App\Classroom;
use App\Http\Classes\Functions;
use App\Monster;
use App\QuestionBank;
use Illuminate\Http\Request;

class BattleController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function schedule($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'question_bank_id' => ['required', 'numeric'],
            'monster_id' => ['required', 'numeric'],
            'options' => ['required', 'array'],
        ]);

        return Battle::create([
            'classroom_id' => $class->id,
            'question_bank_id' => $data['question_bank_id'],
            'monster_id' => $data['monster_id'],
            'options' => json_encode($data['options']),
        ]);
    }

    public function save($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);
        if(request()->passed === 1) {
            $battle = Battle::where('classroom_id', $class->id)->where('id', request()->battle)->firstOrFail();
            $monster = Monster::find($battle->monster_id);
            $student->setProperty("xp", $monster->reward_xp, true, "battle");
            $student->setProperty("gold", $monster->reward_gold, true, "battle");
        }
        $student->battles()->sync([request()->battle => ['passed' => request()->passed, 'state' => json_encode(['question' => request()->currentQuestion, 'time' => request()->time, 'fails'=> request()->fails,'answers' => request()->answers,'monster_hp' => request()->monsterHp])]], false);
        
    }
    public function getInfo($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $data = request()->validate([
            "battle" => ['required', 'numeric'],
        ]);

        $battle = Battle::find($data['battle']);
        $monster = Monster::find($battle->monster_id);
        $bank = QuestionBank::with('questions')->where("id", $battle->question_bank_id)->first();
        $student = Functions::getCurrentStudent($class, ['equipment', 'classroom', 'character']);
        $current = $student->battles()->where('battle_id', $battle->id)->first();

        return ["battle" => $battle, "monster" => $monster, "bank" => $bank, "student" => $student, "current" => $current];
    }

    public function toggle($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'battle' => ['required', 'numeric'],
            'state' => ['required', 'numeric'],
        ]);

        $battle = Battle::find($data['battle']);
        if($battle->classroom_id != $class->id)
            abort(403);
        
        $battle->update(['enabled' => $data['state']]);
        
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->with('battles.monster', 'battles.bank', 'students.equipment', 'students.character', 'grouping.groups.students.equipment', 'grouping.groups.students.character', 'theme', 'questionBanks.questions', 'monsters')->firstOrFail();
        $this->authorize('view', $class);
        
        return view('battles.index', compact('class'));
    }
}
