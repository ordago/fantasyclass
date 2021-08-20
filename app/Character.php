<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    
    // public function character()
    // {
    //     return $this->belongsTo(Character::class, 'character_id', 'id');
    // }
    public function theme() {
        return $this->belongsTo(CharacterTheme::class, 'character_theme_id', 'id');
    }
}
