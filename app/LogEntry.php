<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    protected $fillable = [
        'type',
        'value',
        'student_id',
        'message',
    ];
}
