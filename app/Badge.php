<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
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

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
    public function students() {
        return $this->belongsToMany(Student::class);
    }
}
