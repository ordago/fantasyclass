<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    protected $fillable = [
        'classroom_id',
        'question_bank_id',
        'monster_id',
        'options',
        'enabled',
    ];

    public function monster() {
        return $this->belongsTo(Monster::class);
    }
    public function bank() {
        return $this->belongsTo(QuestionBank::class);
    }
}
