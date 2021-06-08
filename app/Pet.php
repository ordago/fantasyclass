<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{

    protected $fillable = [
        'image',
        'name',
        'hp_boost',
        'xp_boost',
        'gold_boost',
        'price',
        'classroom_id',
        'for_sale',
        'shared',
    ];

    public function students() {
        return $this->belongsToMany(Student::class)->withPivot('hp');
    }


}
