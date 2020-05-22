<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterTheme extends Model
{
    public function characters() {
        return $this->hasMany(Character::class);
    }
}
