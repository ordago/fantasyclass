<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallengesGroup extends Model
{

    protected $fillable = [
                            'name', 
                            'icon', 
                            'classroom_id', 
                            'challenges_group_id',
                        ];

    protected $appends = ['numChallenges'];

    public function getnumChallengesAttribute() 
    {  
        $total = $this->challenges->count();
        foreach ($this->children as $collection) {
            $total += $collection->challenges->count();
        }

        return $total;  
    }

    public function challenges() {
        return $this->hasMany(Challenge::class);   
    }
    

    public function children() {
        return $this->hasMany(ChallengesGroup::class, 'challenges_group_id', 'id');   
    }
    
    public function allChildren() {
        return $this->children()->with('children');
    }
    
    public function parent() {
        return $this->belongsTo(ChallengesGroup::class);   
    }
}
