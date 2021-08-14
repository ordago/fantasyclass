<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Role extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'classroom_id',
        'title',
        'description',
    ];

    protected $appends = ['image'];

    public function getImageAttribute() 
    {  
        $media = $this->getMedia('role')->first();
        if($media){
            return $media->getUrl();
        }
        return "/img/level-default.png";  
    }

    public function registerMediaCollections() : void 
    {
        $this
            ->addMediaCollection('role')
            ->singleFile();
    }
}
