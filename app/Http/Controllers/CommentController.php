<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use App\Comment;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store()
    {

        $data = request()->validate([
            'challenge_id' => ['numeric', 'required'],
            'text' => ['string', 'required'],
        ]);

        $challenge = Challenge::find($data['challenge_id']);
        $class = Classroom::findOrFail($challenge->group->classroom_id);
        $this->authorize('studyOrTeach', $class);

        foreach ($challenge->comments as $comment) {
            $user = User::find($comment->user_id);
            if (!$user->classrooms->where('id', $class->id)->where('pivot.role', '>', 0)->first()) {
                if ($user->id != auth()->user()->id)
                    $user->sendMessage($challenge->title . ": "  . $data['text'], $class->code, "comment", false);
            }
        }

        $comment = Comment::create(['user_id' => auth()->user()->id, 'challenge_id' => $data['challenge_id'], 'text' => $data['text']]);
        $comment->append('info');
        $info = array_merge($comment->info, ['title' => $challenge->title]);

        NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.new_comment", $data['text'], $info, "comment", "challenges");

        return $comment;
    }

    public function destroy($id)
    {

        $comment = Comment::findOrFail($id);
        $class = Classroom::find($comment->challenge->group->classroom_id);
        $this->authorize('update', $class);

        return $comment->delete();
    }
}
