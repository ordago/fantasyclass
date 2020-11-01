<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallengesGroup extends Model
{

    protected $fillable = [
        'name',
        'icon',
        'classroom_id',
        'challenges_group_id',
    ];

    protected $appends = ['numChallenges'];

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

    public function getnumChallengesAttribute()
    {
        // Disabled for now.
        // $total = $this->challenges->count();
        // foreach ($this->children as $collection) {
        //     $total += $collection->challenges->count();
        // }

        // return $total;
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }

    public function children()
    {
        return $this->hasMany(ChallengesGroup::class, 'challenges_group_id', 'id');
    }

    public function allChildren()
    {
        return $this->children()->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(ChallengesGroup::class);
    }

    public static function boot()
    {
        parent::boot();

        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function ($group) 
        {
            $group->challenges()->delete();
            $group->children()->delete();
            $group->allChildren()->delete();
        });
    }
}
