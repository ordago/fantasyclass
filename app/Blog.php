<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $fillable = [
        'student_id',
        'name',
        'public',
    ];

    public function students()
    {
        return $this->belongsTo(Student::class);
    }
    public function posts()
    {
        return $this->hasMany(Posts::class);
    }
}
