<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rows() {
        return $this->hasMany(RubricRow::class);
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function($rubric)
        {
            $rubric->rows()->delete();
        });
    } 
}
