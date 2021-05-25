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

    protected $appends = ['background'];

    public function getBackgroundAttribute() {
        if($this->type == 1 || $this->image) {
            return $this->image;
        } else {
            settings()->setExtraColumns(['classroom_id' => $this->classroom_id]);
            return settings()->get('badge_background', '/img/badges/badge_0.png');
        }
    }

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
