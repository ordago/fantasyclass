<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    protected $fillable = [
        'type',
        'classroom_id',
        'content',
    ];

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
