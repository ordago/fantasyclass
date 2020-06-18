<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Student extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [ 
                            'classroom_user_id', 
                            'name', 
                            'xp', 
                            'hp', 
                            'gold', 
                            'character_id', 
                            'password_plain' ];

    protected $appends = ['username', 'level', 'avatar'];

    public function getAvatarAttribute() 
    {  
        $media = $this->getMedia('avatar')->first();
        if($media){
            return $media->getUrl();
        }
        return "/img/no_avatar.png";  
    }

    
    public function getLevelAttribute() 
    {  
        return Level::where('xp', '<=', $this->xp)->orderByDesc('xp')->first();  
    }

    public function registerMediaCollections() : void 
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();
    }

    public function groups() {
        return $this->belongsToMany(Group::class);
    }

    public function getUsernameAttribute() 
    {  
        return $this->classroom->user->username;  
    }

    public function classroom() {
        return $this->belongsTo(ClassroomUser::class, 'classroom_user_id');
    }

    public function items() {
        return $this->belongsToMany(Item::class)->withPivot('count');
    }

    public function equipment() {
        return $this->belongsToMany(Equipment::class);
    }

    public function logEntries() {
        return $this->hasMany(LogEntry::class);
    }
    
    public function behaviours() {
        return $this->belongsToMany(Behaviour::class)->withTimestamps();
    }

    public function challenges() {
        return $this->belongsToMany(Challenge::class)->withPivot('count');
    }

    public function cards() {
        return $this->belongsToMany(Card::class)->using(CardStudent::class)->withPivot('marked');
    }

    public function setProperty($prop, $value, $log = true) {
        $value = max($this->$prop + $value, 0);
        if($prop == "hp") {
            $value = min($value, 100);
        }
        $this->fill([
            $prop => $value,
        ])->save();
        if($prop == "xp") {
            return[
                'xp' => $value,
                'level' => $this->getLevelAttribute(),
            ];
        }
        return $value;
    }

    public function setBasicEquipment() {

        $this->equipment()->detach($this->equipment);
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
