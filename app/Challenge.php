<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{

    protected $fillable = [
                            'name', 
                            'icon', 
                            'classroom_id', 
                            'challenge_id',
                            'parent',  
                        ];

    public function children() {
        return $this->hasMany(Challenge::class, 'challenge_id', 'id');   
    }
    
    public function allChildren() {
        return $this->children()->with('children');
    }
    
    public function parent() {
        return $this->belongsTo(Challenge::class);   
    }
}
