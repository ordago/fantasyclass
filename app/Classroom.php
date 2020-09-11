<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'adventure_name', 'goal_type', 'theme_id', 'code',
        'enrollment_code', 'user_id', 'character_theme'
    ];

    protected $appends = ['state'];

    public function getStateAttribute() {

        settings()->setExtraColumns(['classroom_id' => $this->id]);
        return settings()->get('state', 0);
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
    public function tags()
    {
        return $this->hasMany(Tag::class);
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
    
    public function maps() {
        return $this->hasMany(Map::class);
    }
    
    public function events() {
        return $this->hasMany(Event::class);
    }

    public function rules() {
        return $this->hasOne(Rules::class);
    }

    public function badges() {
        return $this->hasMany(Badge::class);
    }
    public function evaluables() {
        return $this->hasMany(Evaluable::class);
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function($classroom)
        {
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
        });
    } 
}
