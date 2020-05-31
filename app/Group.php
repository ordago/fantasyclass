<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = [
        'name', 
        'grouping_id', 
    ];


    public function grouping() {
        return $this->belongsTo(Grouping::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class);
    }
}
