<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionGroup extends Model
{
    protected $fillable = [
        'name', 'xp', 'gold'
    ];

    public function collectionables() {
        return $this->hasMany(CollectionableShared::class);
    }
}
