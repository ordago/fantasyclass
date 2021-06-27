<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Collectionable extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type', 'collection_id',
    ];

    protected $appends = ['src'];

    public function getSrcAttribute()
    {
        $media = $this->getMedia('collectionable')->first();
        if ($media) {
            return $media->getUrl();
        }
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('collectionable')
            ->singleFile();
    }

    public function collection() {
        return $this->belongsTo(Collection::class);
    }
}
