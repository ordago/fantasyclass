<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'challenge_id',
        'type',
        'name',
        'url',
        'mode',
    ];

    public function challenge() {
        return $this->belongsTo(Challenge::class);
    }
}
