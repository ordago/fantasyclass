<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Words extends Model
{
    protected $fillable = [
        'word',
        'wordle_id',
    ];

    public function wordle() {
        return $this->belongsTo(Wordle::class);
    }
    public function classroom() {
        return $this->wordle->classroom_id;
    }
}
