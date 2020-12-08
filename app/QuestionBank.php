<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    protected $fillable = [
        'title',
        'classroom_id',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
