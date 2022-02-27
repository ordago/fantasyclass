<?php

namespace App\Http\Controllers;

use App\Classroom;
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

        return ['words' => $words, 'reward' => [$wordle->xp, $wordle->gold]];

    }
}
