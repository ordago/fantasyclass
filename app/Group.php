<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Group extends Model implements HasMedia
{

    use InteractsWithMedia;
    protected $fillable = [
        'name', 
        'grouping_id', 
    ];

    protected $appends = ['logo'];

    public function getLogoAttribute()
    {  
        $media = $this->getMedia('logo')->first();
        if($media){
            return $media->getUrl();
        }
        return "";  
    }

    public function registerMediaCollections() : void 
    {
        $this
            ->addMediaCollection('logo')
            ->singleFile();
    }

    public function grouping() {
        return $this->belongsTo(Grouping::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class);
    }

    public function challenges() {
        return $this->belongsToMany(Challenge::class)->withPivot('count');
    }
}
