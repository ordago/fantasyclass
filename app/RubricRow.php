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

    public function students()
    {
        return $this->belongsToMany(Student::class)->withPivot('rubric_row_item_id');
    }

    public static function boot()
    {
        parent::boot();    
    
        // cause a delete of a product to cascade to children so they are also deleted
        static::deleted(function($rubricRow)
        {
            $rubricRow->items()->delete();
        });
    } 
}
