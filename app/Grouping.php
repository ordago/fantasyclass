<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grouping extends Model
{

    protected $fillable = [
        'name', 
        'classroom_id', 
    ];

    public function groups() {
        return $this->hasMany(Group::class);
    }
}
