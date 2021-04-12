<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\QuestionBank;
use Illuminate\Http\Request;

class BattleController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->with('students.equipment', 'students.character', 'grouping.groups.students.equipment', 'grouping.groups.students.character', 'theme', 'questionBanks.questions', 'monsters')->firstOrFail();
        $this->authorize('view', $class);


        return view('battles.index', compact('class'));
    }
}
