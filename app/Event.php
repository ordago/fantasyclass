<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function classroom() {
        $this->belongsTo(Classroom::class);
    }
}
