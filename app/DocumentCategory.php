<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'classroom_id',
        'order',
    ];

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
