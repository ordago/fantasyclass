<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RubricRow extends Model
{
    protected $fillable = [
        'rubric_id',
        'description',
        'optional',
    ];

    public function items()
    {
        return $this->hasMany(RubricRowItem::class);
    }
    public function rubric()
    {
        return $this->belongsTo(Rubric::class);
    }
}
