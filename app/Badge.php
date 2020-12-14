<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Badge extends Model implements HasMedia
{    
    
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'type',
        'image',
        'icon',
        'classroom_id',
        'hp',
        'xp',
        'gold',
    ];

    public function registerMediaCollections() : void 
    {
        $this
            ->addMediaCollection('badge')
            ->singleFile();
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
    public function students() {
        return $this->belongsToMany(Student::class);
    }
}
