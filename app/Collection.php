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
        'name', 'xp', 'gold', 'shared', 'classroom_id', 'max', 'disabled', 
    ];

    public function collectionables() {
        return $this->hasMany(Collectionable::class);
    }

}
