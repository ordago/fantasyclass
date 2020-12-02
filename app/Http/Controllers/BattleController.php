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
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);

        $banks = $class->questionBanks();

        return view('battles.index', compact('class', 'banks'));
    }
}
