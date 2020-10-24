<?php

namespace App;

use App\Http\Classes\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

class Challenge extends Model
{
    protected $fillable = [
        'icon',
        'color',
        'datetime',
        'description',
        'title',
        'content',
        'is_conquer',
        'xp',
        'hp',
        'gold',
        'cards',
        'completion',
        'auto_assign',
        'optional',
        'type',
        'password',
        'challenges_group_id',
    ];

    protected $appends = ['permalink'];

    public function getPermalinkAttribute() {

        return Crypt::encryptString($this->id);

    }

    public function getQuestioninfoAttribute()
    {
        ChallengesGroup::$withoutAppends = true;
        $questions = collect();
        foreach ($this->questions as $question) {
            $questions->add($question->getStudentInfo());
        }
        return $questions;
    }

    public function getStatsAttribute()
    {
        $questions = collect();
        foreach ($this->questions as $question) {
            $questions->add(['id' => $question->id ,'question' => $question->name , 'stats' => $question->getTeacherInfo()]);
        }
        return $questions;
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('count', 'rating');
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('count');
    }
    public function group()
    {
        return $this->belongsTo(ChallengesGroup::class, 'challenges_group_id', 'id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
    public function classroom()
    {
        return $this->group->classroom_id;
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function($challenge)
        {
            $challenge->attachments()->delete();
            $challenge->comments()->delete();
            $challenge->questions()->delete();     

        });
    } 
}
