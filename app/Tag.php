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

    public function classrroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function evaluables() {
        return $this->belongsToMany(Evaluable::class)->withPivot('weight');
    }
}
