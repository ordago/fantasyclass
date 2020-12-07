<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{

    protected $fillable = [
        'blog_id',
        'title',
        'content',
        'date',
    ];

    public function blog() {
        return $this->belongsTo(Blog::class);
    }
}
