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
        return $this->belongsToMany(User::class)->withPivot('is_admin');
    }

    public function getTheme() {
        return Theme::find($this->theme_id);
    }
}
