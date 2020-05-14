<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [ 'classroom_user_id', 'name', 'xp', 'hp', 'gold', 'password_plain' ];


    public function classroom() {
        return $this->belongsTo(ClassroomUser::class, 'classroom_user_id');
    }

}
