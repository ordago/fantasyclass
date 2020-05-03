<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function theme() {
        return $this->hasOne(Theme::class);
    }
}
