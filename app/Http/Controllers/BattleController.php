<?php

namespace App\Http\Controllers;

use App\Battle;
use App\Classroom;
use App\QuestionBank;
use Illuminate\Http\Request;

class BattleController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function schedule($code) {
        $class = Classroom::where('code', '=', $code)->with('students.equipment', 'students.character', 'grouping.groups.students.equipment', 'grouping.groups.students.character', 'theme', 'questionBanks.questions', 'monsters')->firstOrFail();
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

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->with('students.equipment', 'students.character', 'grouping.groups.students.equipment', 'grouping.groups.students.character', 'theme', 'questionBanks.questions', 'monsters')->firstOrFail();
        $this->authorize('view', $class);


        return view('battles.index', compact('class'));
    }
}
