<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Item extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [ 
        'icon', 
        'hp', 
        'xp',  
        'gold', 
        'slot', 
        'description', 
        'price', 
        'min_lvl', 
        'craft', 
        'for_sale', 
        'classroom_id' ];

        protected $casts = [
            'craft' => 'array',
        ];

        public function registerMediaCollections() : void 
        {
            $this
                ->addMediaCollection('item')
                ->singleFile();
        }
}
