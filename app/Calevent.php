<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calevent extends Model
{
    protected $fillable = [
        'info',
        'group',
        'classroom_id',
        'attendance',
    ];
}
