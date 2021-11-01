<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'g_folder',
        'g_user',
        'g_upload',
        'challenge_id',
    ];

    public function challenge() {
        return $this->belongsTo(Challenge::class);
    }
}
