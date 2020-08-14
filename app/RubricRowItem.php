<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RubricRowItem extends Model
{
    protected $fillable = [
        'rubric_row_id',
        'description',
        'points',
    ];

    public function row() {
        return $this->belongsTo(RubricRow::class);
    }
}
