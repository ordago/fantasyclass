<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xp', 'gold', 'hp', 
    ];
    
    public function classroom() {
        return $this->belongsTo(ClassroomUser::class);
    }

    public function hp() {
        return "asd";
    }
}
