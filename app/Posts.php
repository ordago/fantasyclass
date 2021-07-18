<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = [
        'blog_id',
        'title',
        'content',
        'date',
        'is_teacher',
        'last_edit',
        'student_id',
    ];

    protected $appends = ['student'];

    public function getStudentAttribute()
    {
        if($this->student_id) {
            $student = Student::findOrFail($this->student_id);
            return ['name' => $student->name, 'avatar' => $student->avatar];
        }
        return null;
    }

    public function blog() {
        return $this->belongsTo(Blog::class);
    }
}
