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
        'students',
        'challenges_group_id',
        'challenge_required',
    ];

    protected $appends = ['permalink', 'rating'];

    public function getPermalinkAttribute()
    {
        return Crypt::encryptString($this->id);
    }

    public function getRatingAttribute()
    {
        $query = Rating::where('challenge_id', $this->id);
        if ($query->count())
            return $query->sum('rating') / $query->count();
        return 0;
    }

    public function getQuestioninfoAttribute()
    {
        ChallengesGroup::$withoutAppends = true;
        $questions = collect();
        if ($this->questions)
            foreach ($this->questions as $question) {
                $question = $question->getStudentInfo();
                $answers = [];
                if(isset($question['answers'])) {
                    foreach ($question['answers'] as $answer) {
                        array_push($answers, ['id' => Crypt::encryptString($answer['id']),'text' => $answer['answer']]);
                    }
                    $questions->add(['id' => $question['id'], 'type' => $question['type'],'question' => $question['question'], 'answers' => $answers]);
                } else $questions->add($question);
            }
        return $questions;
    }

    public function getStatsAttribute()
    {
        $questions = collect();
        foreach ($this->questions as $question) {
            $questions->add(['id' => $question->id, 'question' => $question->name, 'stats' => $question->getTeacherInfo()]);
        }
        return $questions;
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('count');
    }

    public function ratings()
    {
        return $this->belongsToMany(Student::class, 'ratings', 'challenge_id', 'student_id')->withPivot('rating');
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
        static::deleted(function ($challenge) {
            $challenge->attachments()->delete();
            $challenge->comments()->delete();
            $challenge->questions()->delete();
        });
    }
}
