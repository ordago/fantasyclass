<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

class ClassroomUser extends Pivot
{
      public function student() {
        return $this->hasOne('App\Student', 'classroom_user_id', 'id');
      }

      public function user() {
          return $this->belongsTo(User::class);
        }
        
        public function classroom() {
          return $this->belongsTo(Classroom::class);
      }

      public function getId() {
        return $this->id;
      }

}
