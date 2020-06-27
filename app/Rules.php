<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    protected $fillable = [
        'type',
        'content',
    ];
}
