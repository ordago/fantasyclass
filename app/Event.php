<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'title',
        'content',
        'classroom_id',
        'options',
        'type',
    ];

    public function classroom() {
        $this->belongsTo(Classroom::class);
    }
}
