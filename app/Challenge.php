<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'icon',
        'datetime',
        'description',
        'title',
        'content',
        'isConquer',
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
