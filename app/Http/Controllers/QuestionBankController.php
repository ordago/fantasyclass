<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\QuestionBank;

class QuestionBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) 
    {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('view', $class);
        $banks = $class->questionBanks;
        return view('questions.index', compact('class', 'banks'));
    }
    
    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);
        $data = request()->validate([
            'title' => ['string', 'required', 'min:3'],
        ]);

        $questionBank = QuestionBank::create([
            'title' => $data['title'],
            'classroom_id' => $class->id,
        ]);
        return $class->questionBanks;
    }

    public function destroy($id)
    {
        $questionBank = QuestionBank::findOrFail($id);
        $class = Classroom::find($questionBank->classroom_id);
        $this->authorize('update', $class);

        return $questionBank->delete();
    }
}
