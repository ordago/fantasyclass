<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Http\Classes\Functions;
use App\Wordle;
use App\Words;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WordleController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $wordles = $class->wordles()->with('words')->get();
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $active = settings()->get('active_wordle', null);
        return view('games.wordle', compact('wordles', 'class', 'active'));
    }
    public function delWord($code, $id)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $word = Words::findOrFail($id);
        $wordle = Wordle::find($word->wordle_id);
        if($wordle->classroom_id == $class->id) {
            $word->delete();
            if(!count($wordle->words))
                $wordle->delete();
            return $class->fresh()->wordles()->with('words')->get();
        }

    }
    public function addWord($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            "wordle" => ['numeric', 'required'],
            "word" => ['string', 'min:4', 'max:6'],
        ]);

        $wordle = Wordle::where('classroom_id', $class->id)->where('id', $data['wordle'])->first();
        Words::create([
            'word' => strtolower($data['word']),
            'wordle_id' => $wordle->id,
        ]);

        return $class->fresh()->wordles()->with('words')->get();
    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'gold' => ['numeric', 'required'],
            'type' => ['numeric', 'required'],
            'xp' => ['numeric', 'required'],
            'dictionary' => ['numeric', 'required'],
        ]);

        Wordle::create([
            'classroom_id' => $class->id,
            'gold' => $data["gold"],
            'xp' => $data["xp"],
            'type' => $data["type"],
            'dictionary' => $data["dictionary"],
        ]);

        return $class->wordles()->with('words')->get();
        
    }

    public function load($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $active = settings()->get('active_wordle', null);
        $wordle = Wordle::find($active);
        if(!$wordle) {
            settings()->set('active_wordle', null);
            abort(501);
        }

        $words = $wordle->words;
        $student = Functions::getCurrentStudent($class);
        $attempt = $student->words()->where('words_id', $words[0]->id)->where("state", 0)->first();
        if($attempt)
            $attempt = $attempt->pivot->word_progress;
        return ['words' => $words, 'reward' => [$wordle->xp, $wordle->gold], 'attempt' => $attempt];

    }

    public function setState($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $student = Functions::getCurrentStudent($class);

        $data = request()->validate([
            "word" => ['numeric', 'required'],
            "progress" => ['array', 'required'],
            "state" => ['numeric', 'required'],
        ]); 

        $word = Words::find($data['word']);
        if($word->classroom() != $class->id) {
            abort(403);
        }

        $wordle = Wordle::find($word->wordle_id);
        
        
        $student->words()->sync([$word->id => ['word_progress' => json_encode($data['progress']), 'state' => $data['state']]], false);
        
        // For now, only one word allowed
        if($data['state'] == 2) {
            $student->setProperty('xp', $wordle->xp, true, 'wordle');
            $student->setProperty('gold', $wordle->gold, true, 'wordle');
        }
        $student->wordle()->sync([$word->wordle->id => ['state' => $data['state']]], false);


    }
}
