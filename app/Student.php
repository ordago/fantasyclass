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
        'password_plain'
    ];

    protected $appends = ['username', 'level', 'avatar', 'grouplogo'];

    public function getAvatarAttribute()
    {
        $media = $this->getMedia('avatar')->first();
        if ($media) {
            return $media->getUrl();
        }
        return "/img/no_avatar.png";
    }
    
    public function getGrouplogoAttribute()
    {
        $group = $this->groups->first();
        if($group)
            return $group->logo;
        return null;
    }


    public function getBoostAttribute()
    {
        return $this->getBoost();
    }

    public function getLevelAttribute()
    {
        return Level::where('xp', '<=', $this->xp)->orderByDesc('xp')->first();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function getUsernameAttribute()
    {
        return $this->classroom->user->username;
    }

    public function classroom()
    {
        return $this->belongsTo(ClassroomUser::class, 'classroom_user_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('count');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class);
    }

    public function logEntries()
    {
        return $this->hasMany(LogEntry::class);
    }

    public function behaviours()
    {
        return $this->belongsToMany(Behaviour::class)->withTimestamps();
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class)->withPivot('count');
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class)->using(CardStudent::class)->withPivot('marked');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('answer');
    }

    public function badges() {
        return $this->belongsToMany(Badge::class);
    }

    public function grades() {
        return $this->belongsToMany(Evaluable::class)->withPivot('grade', 'feedback');
    }

    public function rows()
    {
        return $this->belongsToMany(RubricRow::class, 'rubric_row_student', 'student_id', 'rubric_row_id')->withPivot('rubric_row_item_id');
    }

    public function addBehaviour($behaviourId) {
        $behaviour = Behaviour::findOrFail($behaviourId);
        $behaviour->update(['count_number' => $behaviour->count_number + 1]);
        $this->behaviours()->attach($behaviourId);
        $valHp = $this->setProperty('hp', $behaviour->hp, true);
        $valXp = $this->setProperty('xp', $behaviour->xp, true);
        $valGold = $this->setProperty('gold', $behaviour->gold, true);

        return [
            'hp' => $valHp,
            'xp' => $valXp,
            'gold' => $valGold,
            'level' => $this->getLevelAttribute(),
        ];
    }
    public function getBoost()
    {
        $xp = $gold = $hp = 0;
        foreach ($this->equipment as $item) {
            $xp += $item->xp;
            $gold += $item->gold;
            $hp += $item->hp;
        }
        return [
            'xp' => $xp,
            'hp' => $hp,
            'gold' => $gold,
        ];
    }

    public function setProperty($prop, $value, $log = true, $byPassBoost = false)
    {
        $boost = $this->getBoost();
        $isAlive = $this->hp == 0 ? false : true;

        $old = $value;
        if ($prop == "hp") {
            if ($value >= 0) {
                $value = min($this->$prop + $value, 100);
            } else {
                if(!$byPassBoost)
                    $old = $value - $value * $boost["hp"]/100;
                $value = max($this->$prop + $old, 0);
            }
        } else {
            if ($value >= 0) {
                if(!$byPassBoost)
                    $old = $value + $value * $boost[$prop]/100;
                $value = $this->$prop + $old;
            } else {
                $value = max($this->$prop + $value, 0);
            }
        }

        $this->fill([
            $prop => $value,
        ])->save();

        
        if($prop == 'hp') {
            $checkAlive = $this->hp == 0 ? false : true;
            if($isAlive != $checkAlive) {
                if($isAlive) {
                    $this->setUndead();
                    $this->fill([
                        'xp' => 0,
                        'gold' => 0,
                    ])->save();
                } else {
                    $this->setBasicEquipment();
                }
            }
        }

        if($log && $old != 0) {
            LogEntry::create([
                'type' => $prop,
                'value' => $old,
                'student_id' => $this->id,
            ]);
        }
        if ($prop == "xp") {
            return [
                'xp' => $value,
                'level' => $this->getLevelAttribute(),
            ];
        }
        return $value;
    }
    
    public function setUndead()
    {
        $this->equipment()->detach($this->equipment);
        $this->equipment()->attach([300, 301, 302, 303, 304, 305]);
        
    }
    public function setBasicEquipment()
    {
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
            case '4':
                $ids = [59, 63, 67, 71];
                break;
            case '5':
                $ids = [76, 80, 84, 88, 92];
                break;
            case '6':
                $ids = [96, 100, 108, 112];
                break;
            case '7':
                $ids = [140, 144, 148, 152];
                break;
            case '8':
                $ids = [160, 164, 168, 172];
                break;
            case '9':
                $ids = [180, 184, 188, 192];
                break;
            case '10':
                $ids = [200, 204, 208];
                break;
            case '11':
                $ids = [220, 224, 228];
                break;
            case '12':
                $ids = [240, 244, 248];
                break;
            case '13':
                $ids = [260, 264, 268];
                break;
            case '14':
                $ids = [280, 284, 288];
                break;

        }

        $this->equipment()->attach($ids);
    }
}
