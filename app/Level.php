<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Level extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [ 
        'number', 
        'xp', 
        'title', 
        'description', 
        'classroom_id', 
        ];

    protected $appends = ['imagelvl', 'nextlvl'];

    public function getNextlvlAttribute() 
    {  
        $next = Level::where('classroom_id', $this->classroom_id)->where('xp', ">", $this->xp)->first();
        if($next)
            return $next->xp;
        return 0;
    }
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
