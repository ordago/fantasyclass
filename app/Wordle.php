<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wordle extends Model
{
    protected $fillable = [
        'xp',
        'gold',
        'classroom_id',
        'played',
        'type',
        'dictionary',
    ];

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }

    public function words() {
        return $this->hasMany(Words::class);
    }

    public function student()
    {
        return $this->belongsToMany(Student::class)->withPivot('state');
    }

}
