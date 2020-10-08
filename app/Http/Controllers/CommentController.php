<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store() {
        
        $data = request()->validate([
            'challenge_id' => ['numeric', 'required'],
            'text' => ['string', 'required'],
        ]);

        $class = Classroom::findOrFail(Challenge::find($data['challenge_id'])->group->classroom_id);
        $this->authorize('studyOrTeach', $class);
        
        return Comment::create(['user_id' => auth()->user()->id, 'challenge_id' => $data['challenge_id'], 'text' => $data['text']]);

    }
    
    public function destroy($id) {
    
        $comment = Comment::findOrFail($id);
        $class = Classroom::find($comment->challenge->group->classroom_id);
        $this->authorize('update', $class);

        return $comment->delete();
    }

}
