<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Behaviour extends Model
{
    protected $fillable = [ 
        'icon', 'name', 'custom_text', 'hp', 'xp', 'gold', 'count_number'
    ];
}
