<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'xp', 'gold', 'shared', 'classroom_id',
    ];

    public function collectionables() {
        return $this->hasMany(Collectionable::class);
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function($collection)
        {
            $collection->collectionables()->delete();
        });
    } 
}
