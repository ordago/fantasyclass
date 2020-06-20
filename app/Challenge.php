<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function students() {
        return $this->belongsToMany(Student::class)->withPivot('count');
    }
    public function groups() {
        return $this->belongsToMany(Group::class)->withPivot('count');
    }
    public function group() {
        return $this->belongsTo(ChallengesGroup::class, 'challenges_group_id', 'id');
    }
    public function attachments() {
        return $this->hasMany(Attachment::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function questions() {
        return $this->hasMany(Question::class);
    }

}
