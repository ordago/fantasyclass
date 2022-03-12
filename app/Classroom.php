<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Classroom extends Model implements HasMedia
{

    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pets');
        $this->addMediaCollection('avatars');
        $this->addMediaCollection('documents');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'adventure_name', 'goal_type', 'theme_id', 'code',
        'enrollment_code', 'user_id', 'character_theme', 'share_code'
    ];

    protected $appends = ['state', 'background'];

    public function getStateAttribute()
    {

        settings()->setExtraColumns(['classroom_id' => $this->id]);
        return settings()->get('state', 0);
    }

    public function getBackgroundAttribute()
    {

        settings()->setExtraColumns(['classroom_id' => $this->id]);
        $default = "";
        if ($this->theme) {
            $default = "/img/bg/base/thumb_" . $this->theme->name;
        }
        return settings()->get('background', $default);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(ClassroomUser::class)->withPivot('role', 'id');
    }

    public function goal()
    {
        return $this->hasOne(GoalThemes::class, 'id', 'goal_type');
    }

    public function students()
    {
        return $this->hasManyThrough('App\Student', 'App\ClassroomUser', 'classroom_id', 'classroom_user_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class)->with('collectionables');
    }

    public function questionBanks()
    {
        return $this->hasMany(QuestionBank::class);
    }
  
    public function wordles()
    {
        return $this->hasMany(Wordle::class);
    }
    public function battles()
    {
        return $this->hasMany(Battle::class);
    }

    public function evalgroups()
    {
        return $this->hasMany(EvaluablesGroup::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function theme()
    {
        return $this->hasOne(Theme::class, 'id', 'theme_id');
    }

    public function characterTheme()
    {
        return $this->hasOne(CharacterTheme::class, 'id', 'character_theme');
    }

    public function grouping()
    {
        return $this->hasMany(Grouping::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function behaviours()
    {
        return $this->hasMany(Behaviour::class);
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function challengeGroups()
    {
        return $this->hasMany(ChallengesGroup::class);
    }

    public function maps()
    {
        return $this->hasMany(Map::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function monsters()
    {
        return $this->hasMany(Monster::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function rules()
    {
        return $this->hasOne(Rules::class);
    }

    public function badges()
    {
        return $this->hasMany(Badge::class);
    }
    public function evaluables()
    {
        return $this->hasMany(Evaluable::class);
    }

    public function documents()
    {
        return $this->hasMany(DocumentCategory::class);
    }

    public function videochats()
    {
        return $this->hasMany(Videochat::class);
    }

    public function calevents()
    {
        return $this->hasMany(Calevent::class);
    }
    
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public static function boot()
    {
        parent::boot();

        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function ($classroom) {
            $classroom->students()->delete();
            $classroom->cards()->delete();
            $classroom->grouping()->delete();
            $classroom->behaviours()->delete();
            $classroom->items()->delete();
            $classroom->levels()->delete();
            $classroom->challengeGroups()->delete();
            $classroom->maps()->delete();
            $classroom->rules()->delete();
            $classroom->badges()->delete();
            $classroom->evaluables()->delete();
            $classroom->skills()->delete();
            $classroom->monsters()->delete();
            $classroom->events()->delete();
            $classroom->documents()->delete();
            $classroom->collections()->delete();
            $classroom->questionBanks()->delete();
            $classroom->rules()->delete();
            $classroom->videochats()->delete();
        });
    }
}
