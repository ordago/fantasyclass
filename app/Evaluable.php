<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluable extends Model
{
    protected $fillable = [
        'description',
        'type',
        'rubric_id',
        'challenge_id',
    ];

    public function evaluables() {
        return $this->belongsToMany(Tag::class)->withPivot('weight');
    }

}
