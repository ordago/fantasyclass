<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = [
        'url',
        'classroom_id',
        'name',
    ];

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
