<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [ 
        'icon', 
        'hp', 
        'xp',  
        'gold', 
        'description', 
        'price', 
        'min_lvl', 
        'for_sale', 
        'classroom_id' ];

    

}
