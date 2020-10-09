<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{

    protected $fillable = [
        'image',
        'hp',
        'hp_boost',
        'xp_boost',
        'gold_boost',
        'price',
    ];



}
