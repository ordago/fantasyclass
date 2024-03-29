<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class LevelShared extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [ 
        'number', 
        'xp', 
        'title', 
        'description',
        'level_group_id', 
        ];

    protected $appends = ['imagelvl'];

    public function getImagelvlAttribute() 
    {  
        $media = $this->getMedia('level')->first();
        if($media){
            return $media->getUrl();
        }
        return "/img/level-default.png";  
    }

    public function registerMediaCollections() : void 
    {
        $this
            ->addMediaCollection('level')
            ->singleFile();
    }
}
