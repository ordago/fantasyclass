<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store()
    {
        dump(request()->all());
        $data = request()->validate([
            'question.challenge_id' => ['numeric', 'required'],
            'question.question' => ['string', 'required'],
            'question.correctAnswer' => ['string', 'required'],
            'question.incorrectAnswer1' => ['string', 'required'],
            'question.incorrectAnswer2' => ['string', 'nullable'],
            'question.incorrectAnswer3' => ['string', 'nullable'],
        ]);

        $class = Classroom::findOrFail(Challenge::find($data['question']['challenge_id'])->group->classroom_id);
        $this->authorize('update', $class);

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
        dump('hit');
        if ($data['question']['incorrectAnswer2']) {
            $id = $ids->pop();
            $options->add(['answer' => ['id' => $id, 'text' => $data['question']['incorrectAnswer2']]]);
        }
        if ($data['question']['incorrectAnswer3']) {
            $id = $ids->pop();
            $options->add(['answer' => ['id' => $id, 'text' => $data['question']['incorrectAnswer3']]]);
        }

        return Question::create([
            'challenge_id' => $data['question']['challenge_id'],
            'name' => $data['question']['question'],
            'options' => $options->shuffle(),
        ]);
    }

    public function destroy($id)
    {

        $attachment = Attachment::findOrFail($id);
        $class = Classroom::find($attachment->challenge->group->classroom_id);
        $this->authorize('update', $class);

        return $attachment->delete();
    }
}
