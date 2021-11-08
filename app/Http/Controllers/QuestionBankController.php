<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Exports\Export;
use App\Question;
use App\QuestionBank;
use Maatwebsite\Excel\Facades\Excel;

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

    public function addImage()
    {
        $data = request()->validate([
            'question_id' => ['numeric', 'required'],
        ]);

        $question = Question::findOrFail($data['question_id']);
        $class = Classroom::find($question->questionBank->classroom_id);
        $this->authorize('update', $class);

        if (request()->image) {
            $question->addMedia(request()->file('image'))
                ->toMediaCollection('questions');
        } else {
            $question->clearMediaCollection('questions');
        }
        return $question->fresh();
    }

    public function destroy($id)
    {
        $questionBank = QuestionBank::findOrFail($id);
        $class = Classroom::find($questionBank->classroom_id);
        $this->authorize('update', $class);

        return $questionBank->delete();
    }

    public function downloadQuestionBank($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $data = request()->validate([
            'id' => ['numeric', 'required'],
        ]);
        $bank = QuestionBank::where('classroom_id', '=', $class->id)->where('id', '=', $data['id'])->firstOrFail();
        
        $headings = [
            "Title",
            "CorrectAnswer",
            "Incorrect1",
            "Incorrect2",
            "Incorrect3",
        ];

        $questions = [];
        foreach ($bank->questions()->where('type', 1)->get() as $question) {
            $correctAnswer = null;
            $incorrect = [];
            $correct = 0;
            foreach ($question->options as $option) {
                if(isset($option['correctAnswer'])) {
                    $correct = $option['correctAnswer'];
                } else {
                    if($correct == $option['answer']['id']) {
                        $correctAnswer = $option['answer']['text'];
                    } else {
                        array_push($incorrect, $option['answer']['text']);
                    }
                }
            }
            array_push($questions, ['Title' => $question->name, 'CorrectAnswer' => $correctAnswer, 'Incorrect1' => $incorrect[0], 'Incorrect2' => isset($incorrect[1]) ? $incorrect[1] : '', 'Incorrect3' => isset($incorrect[2]) ? $incorrect[2] : '']);
            
        }

        return Excel::download(new Export($headings, $questions), $bank->title . '.xlsx');

    }
}
