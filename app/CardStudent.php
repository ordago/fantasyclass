<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CardStudent extends Pivot
{

      public function student() {
          return $this->belongsTo(Student::class);
        }
        
        public function card() {
          return $this->belongsTo(Card::class);
      }

}
