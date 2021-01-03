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
    ];

    public function blog() {
        return $this->belongsTo(Blog::class);
    }
}
