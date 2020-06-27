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

    protected $appends = ['username', 'level', 'avatar'];

    public function getAvatarAttribute()
    {
        $media = $this->getMedia('avatar')->first();
        if ($media) {
            return $media->getUrl();
        }
        return "/img/no_avatar.png";
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

    public function setProperty($prop, $value)
    {
        $boost = $this->getBoost();
        if ($prop == "hp") {
            if ($value >= 0) {
                $value = min($this->$prop + $value, 100);
            } else {
                $value = max($this->$prop + ($value - $value * $boost['hp'] / 100), 0);
            }
        } else {
            if ($value >= 0) {
                $value = $this->$prop + $value + $value * $boost[$prop] / 100;
            } else {
                $value = max($this->$prop + $value, 0);
            }
        }

        $this->fill([
            $prop => $value,
        ])->save();
        if ($prop == "xp") {
            return [
                'xp' => $value,
                'level' => $this->getLevelAttribute(),
            ];
        }
        LogEntry::create([
            'type' => $prop,
            'value' => $value,
            'student_id' => $this->id,
        ]);
        return $value;
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
