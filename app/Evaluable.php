<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluable extends Model
{

    protected $fillable = [
        'description',
        'classroom_id',
        'type',
        'rubric_id',
        'challenge_id',
    ];
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withPivot('weight');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('grade', 'feedback');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function($evaluable)
        {
            $evaluable->students()->sync([]);
        });
    } 

}
