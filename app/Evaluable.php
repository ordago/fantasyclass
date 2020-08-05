<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluable extends Model
{
    protected $fillable = [
        'description',
        'classroom_id',
        'type',
        'rubric_id',
        'challenge_id',
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class)->withPivot('weight');
    }
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

}
