<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'challenge_id',
        'text',
    ];

    protected $appends = ['info'];


    public function getInfoAttribute() {

        $challenge = Challenge::find($this->challenge_id);
        $student = ClassroomUser::where('user_id', $this->user_id)
        ->where('classroom_id', $challenge->group->classroom_id)
        ->where('role', 0)->first();
        $date = date_create($this->created_at);
        if($student) {
            $student = $student->student;
            return ['type' => 'student','name' => $student->name, 'avatar' => $student->getAvatarAttribute(), "datetime" => $date];
        }
        $user = User::find($this->user_id);
        return ['type' => 'teacher', 'name' => $user->name, 'avatar' => '<i class="fas fa-user-graduate text-light textshadow"></i>', "datetime" => $date];

    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function challenge() {
        return $this->belongsTo(Challenge::class);
    }

}
