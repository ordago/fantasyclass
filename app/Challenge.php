<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'icon',
        'color',
        'datetime',
        'description',
        'title',
        'content',
        'is_conquer',
        'xp',
        'hp',
        'gold',
        'cards',
        'auto_assign',
        'optional',
        'password',
        'challenges_group_id',
    ];


}
