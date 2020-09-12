<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'short',
        'description',
        'percent',
        'classroom_id',
    ];

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function evaluables() {
        return $this->belongsToMany(Evaluable::class)->withPivot('weight');
    }
}
