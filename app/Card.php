<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Card extends Model implements HasMedia
{
    use InteractsWithMedia;
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
        public function registerMediaCollections() : void 
        {
            $this
                ->addMediaCollection('card')
                ->singleFile();
        }

}
