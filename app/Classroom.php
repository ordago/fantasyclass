<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'adventure_name', 'goal_type', 'theme_id', 'char_theme', 'code',
        'enrollment_code', 'user_id', 'character_theme' 
    ];

    public function users() {
        return $this->belongsToMany(User::class)->using(ClassroomUser::class)->withPivot('role', 'id');
    }

    public function students() {
        return $this->hasManyThrough('App\Student', 'App\ClassroomUser', 'classroom_id', 'classroom_user_id', 'id');
    }

    public function theme() {
        return $this->hasOne(Theme::class, 'id', 'theme_id');
    }

    public function cards() {
        return $this->hasMany(Card::class);
    }

    public function behaviours() {
        return $this->hasMany(Behaviour::class);
    }
}
