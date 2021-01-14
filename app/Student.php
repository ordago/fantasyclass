<?php

namespace App;

use App\Http\Classes\Functions;
use App\Http\Controllers\CardsController;
use App\Notifications\NewInteraction;
use App\Notifications\NewInteractionStudent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
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
        'password_plain',
        'hidden',
        'avatar_url',
        'google_uid',
        'google_course',
    ];

    protected $appends = ['username', 'level', 'avatar', 'grouplogo', 'online'];

    public function getOnlineAttribute()
    {
        $id = $this->getUserId();
        if (Cache::has('user-is-online-' . $id))
            return true;
        else
            return false;
    }



    public function getAvatarAttribute()
    {
        if ($this->avatar_url)
            return $this->avatar_url;

        $media = $this->getMedia('avatar')->first();
        if ($media) {
            return $media->getUrl();
        }

        return "/img/no_avatar.png";
    }


    public function getGrouplogoAttribute()
    {
        $group = $this->groups->first();
        if ($group) {
            if ($group->logo)
                return $group->logo;
            return "/img/no_group_avatar.png";
        }
        return null;
    }

    public function getGrouplogopublicAttribute()
    {
        $group = $this->groups->first();
        if ($group) {
            if ($group->logo)
                return $group->logo;
            return "/img/no_group_avatar.png";
        }
        return null;
    }

    public function getNumcardsAttribute()
    {
        settings()->setExtraColumns(['classroom_id' => $this->classroom->classroom_id]);

        $num = 0;
        $max = settings()->get('num_cards', 5);

        $skill = $this->skills()->where('properties->type', "cards")->first();
        if($skill)
            $max += $skill->properties['cards'];
        
        foreach ($this->cards as $card) {
            if ($card->special != 1)
                $num++;
            if ($card->slot != 0)
                $max += $card->slot;
        }
        foreach ($this->items as $item) {
            if ($item->slot != 0)
                $max += $item->slot;
        }
        return [$num, $max];
    }

    public function getBoostAttribute()
    {
        return $this->getBoost();
    }

    public function getLevelAttribute()
    {
        return Level::where('xp', '<=', $this->xp)->where('classroom_id', $this->classroom->classroom_id)->orderByDesc('xp')->first();
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

    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id', 'id');
    }

    public function pets()
    {
        return $this->belongsToMany(Pet::class)->withPivot('hp');
    }

    public function getUserId()
    {
        return $this->classroom->user->id;
    }

    public function getUsernameAttribute()
    {
        return $this->classroom->user->username;
    }

    public function pet()
    {
        return $this->hasOne(Pet::class);
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

    public function ratings()
    {
        return $this->belongsToMany(Challenge::class, 'ratings', 'student_id', 'challenge_id')->withPivot('rating');
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class)->using(CardStudent::class)->withPivot('marked');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('answer');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

    public function grades()
    {
        return $this->belongsToMany(Evaluable::class)->withPivot('grade', 'feedback');
    }

    public function rows()
    {
        return $this->belongsToMany(RubricRow::class, 'rubric_row_student', 'student_id', 'rubric_row_id')->withPivot('rubric_row_item_id');
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('count');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function addBehaviour($behaviourId)
    {
        $behaviour = Behaviour::findOrFail($behaviourId);
        $behaviour->update(['count_number' => $behaviour->count_number + 1]);
        $this->behaviours()->attach($behaviourId);
        $valHp = $this->setProperty('hp', $behaviour->hp, true, 'behaviour');
        $valXp = $this->setProperty('xp', $behaviour->xp, true, 'behaviour');
        $valGold = $this->setProperty('gold', $behaviour->gold, true, 'behaviour');

        $from['title'] = __('notifications.new_behaviour');
        $from['name'] = "FantasyClass";
        $from['datetime'] = Carbon::now();

        $behaviourText = $behaviour->custom_text ? $behaviour->custom_text : __($behaviour->name);

        Notification::send($this->classroom->user, new NewInteractionStudent(__('notifications.new_behaviour'), __($behaviourText), $from, "new_behaviour", $this->classroom->classroom->code));

        return [
            'hp' => $valHp,
            'xp' => $valXp,
            'gold' => $valGold,
            'level' => $this->getLevelAttribute(),
        ];
    }

    public function getAutomaticBadges()
    {

        $class = Classroom::findOrFail($this->classroom->classroom_id);

        $badges = collect();
        $badge = new Badge();

        $f = true;
        if ($this->behaviours->count() != 0) {
            foreach ($this->behaviours as $behaviour) {
                if ($behaviour->hp < 0 || $behaviour->xp < 0 || $behaviour->gold < 0) {
                    $f = false;
                }
            }
        }
        if ($f) {
            $badge->fill([
                'title' => __('badges.badge_exemplar'),
                'description' => __('badges.badge_exemplar_info') . '💪',
                'type' => 0,
                'image' => null,
                'icon' => 'fad fa-crown',
                'classroom_id' => '',
                'hp' => 0,
                'xp' => 0,
                'gold' => 0,
            ]);
            $badges->push($badge->replicate());
        }

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $f = true;

        if (settings()->get('eval_visible', false)) {
            $max = settings()->get('eval_max', false);
            $count1 = 0;
            $count2 = 0;
            $count3 = 0;
            $message = __('badges.academic_info');
            foreach ($this->grades as $grade) {
                $grade = $grade->pivot->grade * 10 / $max;
                if ($grade >= 8.5) {
                    $count1++;
                } else if ($grade >= 7.5) {
                    $count2++;
                } else if ($grade >= 6.5) {
                    $count3++;
                } else {
                    $f = false;
                }
            }
            if ($f) {
                if ($count3) {
                    $message .= "6.5!";
                    $icon = "fad fa-tachometer-alt-average";
                } else if ($count2) {
                    $message .= "7.5!";
                    $icon = "fad fa-tachometer-alt-fast";
                } else {
                    $message .= "8.5!";
                    $icon = "fad fa-tachometer-alt-fastest";
                }
                $badge->fill([
                    'title' => __('badges.academic'),
                    'description' => $message,
                    'type' => 0,
                    'image' => null,
                    'icon' => $icon,
                    'classroom_id' => '',
                    'hp' => 0,
                    'xp' => 0,
                    'gold' => 0,
                ]);
                $badges->push($badge->replicate());
            }
        }

        $f = true;

        foreach ($class->challengeGroups as $group) {
            $count = $group->challenges->where('is_conquer', 1)->count();
            if ($count == 0)
                continue;
            foreach ($group->challenges as $challenge) {
                if ($this->challenges->contains($challenge->id)) {
                    $count--;
                }
            }
            if ($count === 0) {
                $badge->fill([
                    'title' => $group->name,
                    'description' => __('badges.challenge_info', ['name' => $group->name]) . '😊',
                    'type' => 0,
                    'image' => null,
                    'icon' => $group->icon,
                    'classroom_id' => '',
                    'hp' => 0,
                    'xp' => 0,
                    'gold' => 0,
                ]);
                $badges->push($badge->replicate());
            }
        }



        return $badges;
    }

    public function assignChallenge($challenge, $mult = 1, $cards = [])
    {
        $this->setProperty('hp', $mult * $challenge->hp, true, 'challenge');
        $this->setProperty('xp', $mult * $challenge->xp, true, 'challenge');
        $this->setProperty('gold', $mult * $challenge->gold, true, 'challenge');
        if (count($cards) && $mult == 1) {
            foreach ($cards as $card) {
                $this->cards()->attach($card);
                LogEntry::create([
                    'type' => 'card_assign',
                    'value' => 0,
                    'student_id' => $this->id,
                    'message' => 'card_assign',
                    'info' => $card->title,
                ]);
            }
        }

        if ($challenge->items) {
            foreach ($challenge->items as $item) {
                $studentItem = $this->items->where('id', $item['id'])->first();
                if ($studentItem)
                    $count = $studentItem->pivot->count + $mult;
                else $count = $mult == -1 ? 0 : 1;
                if ($count <= 0) {
                    $this->items()->detach($item['id']);
                } else {
                    $this->items()->sync([$item['id'] => ['count' => $count]], false);
                }
            }
        }
        if ($challenge->requirements) {
            foreach ($challenge->requirements as $item) {
                $studentItem = $this->fresh()->items->where('id', $item['id'])->first();
                if ($studentItem)
                    $count = $studentItem->pivot->count + $mult * -1;
                else $count = 1;
                if ($count <= 0) {
                    $this->items()->detach($item['id']);
                } else {
                    $this->items()->sync([$item['id'] => ['count' => $count]], false);
                }
            }
        }
    }


    public function getBoost()
    {
        $xp = $gold = $hp = 0;
        foreach ($this->equipment as $item) {
            $xp += $item->xp;
            $gold += $item->gold;
            $hp += $item->hp;
        }

        $pet = $this->pets->first();
        if ($pet) {
            $xp += $pet->xp_boost;
            $gold += $pet->gold_boost;
            $hp += $pet->hp_boost;
        }

        return [
            'xp' => $xp,
            'hp' => $hp,
            'gold' => $gold,
        ];
    }

    public function checkSkill($type)
    {
        $skill = $this->skills()->where('properties->type', $type)->first();
        if($skill && Functions::getProbability($skill->properties['success']))
            return true;
        return false;
    }

    public function skillRemove($type)
    {
        $skill = $this->skills()->where('properties->type', $type)->first();
        $this->skills()->detach($skill->id);
    }

    public function getIncrement($type, $value)
    {
        $skill = $this->skills()->where('properties->type', $type)->first();
        return $value * $skill->properties['hp_increment']/100;
    }

    public function setProperty($prop, $value, $log = true, $type = null, $byPassBoost = false)
    {
        $boost = $this->getBoost();
        $isAlive = $this->hp == 0 ? false : true;

        $old = $value;
        if ($prop == "hp") {
            if($value < 0 && $this->checkSkill('protection')) {
                $this->classroom->user->sendMessage("<i class='fad fa-shield'></i> ". __('skills.protection_success'), $this->classroom->classroom->code, 'skill', false);
                return $this->hp;
            }
            if ($value >= 0) {
                $value = min($this->$prop + $value, 100);
            } else {
                if (!$byPassBoost)
                    $old = $value - $value * $boost["hp"] / 100;
                $value = max($this->$prop + $old, 0);
            }
        } else {
            if ($value >= 0) {
                if (!$byPassBoost)
                    $old = $value + $value * $boost[$prop] / 100;
                $value = $this->$prop + $old;
            } else {
                $value = max($this->$prop + $value, 0);
            }
        }

        $this->fill([
            $prop => $value,
        ])->save();


        if ($prop == 'hp') {
            $checkAlive = $this->hp == 0 ? false : true;
            if ($isAlive != $checkAlive) {
                if ($isAlive) {
                    if($this->checkSkill('protection_death')) {
                        $this->update(['hp' => 1]);
                        $this->classroom->user->sendMessage(__('skills.protection_death_effective'), $this->classroom->classroom->code, 'skill', false);
                        $this->skillRemove('protection_death');
                    } else {
                        $this->setUndead();
                        $this->setProperty('xp', $this->xp * -1);
                        $this->setProperty('gold', $this->gold * -1);
                    }
                } else {
                    $this->setBasicEquipment();
                }
            }
        }

        if ($log && $old != 0) {
            LogEntry::create([
                'type' => $prop,
                'value' => $old,
                'student_id' => $this->id,
                'message' => $type,
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
        $this->equipment()->attach([300, 301, 302, 303, 304]);
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
            case '16':
                $ids = [310, 314, 318, 322, 326];
                break;
            case '17':
                $ids = [330, 334, 338, 342, 346];
                break;
            case '18':
                $ids = [350, 354, 358, 362, 366];
                break;
            case '19':
                $ids = [370, 374, 378, 382, 386];
                break;
            case '20':
                $ids = [390, 394, 398, 402, 406];
                break;
            case '21':
                $ids = [410, 414, 418, 422, 426];
                break;
            case '22':
                $ids = [430, 434, 438, 442, 446];
                break;
            case '23':
                $ids = [450, 454, 458, 462];
                break;
            case '24':
                $ids = [470, 474, 478, 482];
                break;
            case '25':
                $ids = [490, 494, 498, 502];
                break;
        }

        $this->equipment()->attach($ids);
    }
}
