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

        return ["battle" => $battle, "monster" => $monster, "bank" => $bank, "student" => $student];
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
