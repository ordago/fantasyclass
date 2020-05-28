<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [ 
                            'classroom_user_id', 
                            'name', 
                            'xp', 
                            'hp', 
                            'gold', 
                            'character_id', 
                            'password_plain' ];

    protected $appends = ['username', 'level'];

    
    public function getLevelAttribute() 
    {  
        return Level::where('xp', '<=', $this->xp)->orderByDesc('xp')->first();  
    }


    public function getUsernameAttribute() 
    {  
        return $this->classroom->user->username;  
    }

    public function classroom() {
        return $this->belongsTo(ClassroomUser::class, 'classroom_user_id');
    }


    public function equipment() {
        return $this->belongsToMany(Equipment::class);
    }
    
    public function behaviours() {
        return $this->belongsToMany(Behaviour::class);
    }

    public function setProperty($prop, $value) {
        $value = max($this->$prop + $value, 0);
        $this->fill([
            $prop => $value,
        ])->save();
        return $value;
    }

    public function setBasicEquipment() {
        switch ($this->character_id) {
            case '1':
                $ids = [1, 5, 9, 13, 17, 21];
                break;
            case '2':
                $ids = [25, 29, 33, 37, 41];
                break;
            case '3':
                $ids = [42, 46, 50, 51, 55];
            break;
            
        }

        $this->equipment()->attach($ids);

    }

}
