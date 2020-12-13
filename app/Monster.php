<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    protected $fillable = [
        'image',
        'name',
        'hp',
        'classroom_id',
        'reward_xp',
        'reward_gold',
    ];

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
