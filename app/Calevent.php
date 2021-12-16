<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calevent extends Model
{
    protected $fillable = [
        'info',
        'group',
        'task',
        'classroom_id',
        'subject_id',
        'attendance',
    ];

    public function students() {
        return $this->belongsToMany(Student::class)->withPivot('type');
    }
}
