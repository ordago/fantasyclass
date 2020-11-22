<?php

namespace App\Http\Controllers;


class QuestionBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store()
    {
        $data = request()->validate([
            'question.challenge_id' => ['numeric', 'required'],
        ]);

        // $class = Classroom::findOrFail(Challenge::find($data['question']['challenge_id'])->group->classroom_id);
        // $this->authorize('update', $class);

    }


    public function destroy($id)
    {

        // $question = Question::findOrFail($id);
        // $class = Classroom::find($question->challenge->group->classroom_id);
        // $this->authorize('update', $class);

        // return $question->delete();
    }
}
