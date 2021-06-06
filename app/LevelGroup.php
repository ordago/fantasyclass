<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelGroup extends Model
{
    protected $fillable = [
        'name', 
    ];

    public function levels() {
        return $this->hasMany(LevelShared::class);
    }
}
