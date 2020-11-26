<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use App\Http\Classes\Functions;
use App\Question;
use App\QuestionBank;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store()
    {

        if (request()->type == 1) {
            $data = request()->validate([
                'question.name' => ['string', 'required'],
                'question.correctAnswer' => ['string', 'required'],
                'question.incorrectAnswer1' => ['string', 'required'],
                'question.incorrectAnswer2' => ['string', 'nullable'],
                'question.incorrectAnswer3' => ['string', 'nullable'],
            ]);

            $num = 2;
            $ids = collect();
    
            if ($data['question']['incorrectAnswer2'])
                $num++;
            if ($data['question']['incorrectAnswer3'])
                $num++;
            for ($i = 1; $i <= $num; $i++) {
                $ids->add($i);
            }
    
            $options = collect();
            $ids = $ids->shuffle();
            $id = $ids->pop();
            $options->add(['correctAnswer' => $id]);
            $options->add(['answer' => ['id' => $id, 'text' => $data['question']['correctAnswer']]]);
            $id = $ids->pop();
            $options->add(['answer' => ['id' => $id, 'text' => $data['question']['incorrectAnswer1']]]);
            if ($data['question']['incorrectAnswer2']) {
                $id = $ids->pop();
                $options->add(['answer' => ['id' => $id, 'text' => $data['question']['incorrectAnswer2']]]);
            }
            if ($data['question']['incorrectAnswer3']) {
                $id = $ids->pop();
                $options->add(['answer' => ['id' => $id, 'text' => $data['question']['incorrectAnswer3']]]);
            }

        } else if (request()->type == 2) {
            $data = request()->validate([
                'bank' => ['numeric', 'required'],
                'type' => ['numeric', 'required'],
                'question.name' => ['string', 'required', 'min:3'],
                'question.answers' => ['array'],
            ]);
            $options = $data['question']['answers'];

        }

        $bank = request()->bank;
        $challenge = isset(request()->question['challenge_id']) ? request()->question['challenge_id'] : null;
        if($bank) {
            $class = Classroom::findOrFail(QuestionBank::find($bank)->classroom_id);
        } else {
            $class = Classroom::findOrFail(Challenge::find(request()->question['challenge_id'])->group->classroom_id);
        }

        $this->authorize('update', $class);



        return Question::create([
            'challenge_id' => $challenge,
            'question_bank_id' => $bank,
            'name' => $data['question']['name'],
            'options' => $options,
        ]);
    }

    public function index($code, $bank)
    {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);

        // That is whithout category, just for clarify
        if ($bank == "wc") {
            $challenges = [];
            foreach ($class->challengeGroups as $cg) {
                foreach ($cg->challenges as $challenge) {
                    array_push($challenges, $challenge->id);
                }
            }
            return Question::whereIn('challenge_id', $challenges)->get();
        }
        $bank = QuestionBank::find($bank);
        if ($class->id != $bank->classroom_id)
            abort(403);
        return $bank->questions;
    }

    public function answer()
    {
        $question = Question::find(request()->question['id']);
        $class = Classroom::where('id', $question->challenge->group->classroom_id)->first();
        $this->authorize('study', $class);

        $student = Functions::getCurrentStudent($class, []);
        if ($student->questions->contains($question->id))
            return false;

        $student->questions()->attach($question->id, [
            'answer' => request()->answer,
        ]);
        return $question->getStudentInfo();
    }

    public function destroy($id)
    {

        $question = Question::findOrFail($id);
        $class = Classroom::find($question->challenge->group->classroom_id);
        $this->authorize('update', $class);

        return $question->delete();
    }
}
