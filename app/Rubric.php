<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];
}
