<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'name',
        'challenge_id',
        'options'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function challenge() {
        return $this->belongsTo(Challenge::class);
    }
}
