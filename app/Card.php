<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [ 
                'src', 
                'title',
                'description',
                'min_lvl',
                'type',
                'special',
                'width',
                'margin_top',
                'margin_left',
                'background',
                'radius',
                'xp',
                'hp',
                'gold',
                'slot',
                'fullscreen',
                'classroom_id',
                'type_bg',

];

}
