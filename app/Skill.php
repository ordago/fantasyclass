<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{

    protected $fillable = [
        'name',
        'icon',
        'type',
        'description',
        'classroom_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('count');
    }
}
