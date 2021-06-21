<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluablesGroup extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'classroom_id',
    ];

    protected $appends = ['numEvaluables'];

    /**
     * @var bool
     */
    public static $withoutAppends = false;

    /**
     * Check if $withoutAppends is enabled.
     *
     * @return array
     */
    protected function getArrayableAppends()
    {
        if (self::$withoutAppends) {
            return [];
        }
        return parent::getArrayableAppends();
    }

    public function getnumEvaluablesAttribute()
    {
        // Disabled for now.
        // $total = $this->evaluables->count();
        // foreach ($this->children as $collection) {
        //     $total += $collection->evaluables->count();
        // }

        // return $total;
    }

    public function evaluables()
    {
        return $this->hasMany(Evaluable::class);
    }
    
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function parent()
    {
        return $this->belongsTo(EvaluablesGroup::class);
    }

    public static function boot()
    {
        parent::boot();

        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function ($group)
        {
            $group->evaluables()->delete();
        });
    }
}
