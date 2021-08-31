<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CollectionableShared extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [ 
        'name', 
        'description', 
        'type', 
        'collection_group_id',
        ];

    protected $appends = ['src'];

    public function getSrcAttribute() 
    {  
        $media = $this->getMedia('collectionable')->first();
        if($media){
            return $media->getUrl();
        }
        return "";  
    }

    public function registerMediaCollections() : void 
    {
        $this
            ->addMediaCollection('collectionable')
            ->singleFile();
    }
}
