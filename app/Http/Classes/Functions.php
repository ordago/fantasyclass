<?php

namespace App\Http\Classes;

use App\Student;

class Functions
{
  
  /***
   * Replace special chars
   */
  public static function replaceSpecial($text, $class = null) {
    // $text = str_replace('[tex]', '\[', $text);
    // $text = str_replace('[/tex]', '\]', $text);
    $text = str_replace('%XP%', "<i class='fas fa-fist-raised colored'></i>", $text);
    $text = str_replace('%GOLD%', "<i class='fas fa-coins colored'></i>", $text);
    $text = str_replace('%HP%', "<i class='fas fa-heart colored'></i>", $text);
    $text = str_replace('%BR%', "<br>", $text);
    $text = str_replace('%br%', "<br>", $text);
    $text = str_replace('%CARD%', "<svg style='width:24px;height:24px;margin-top:-7px;' viewBox='0 0 24 24'>
    <path stroke='#000' stroke-width='1.5px' fill='#fff' d='M21.47,4.35L20.13,3.79V12.82L22.56,6.96C22.97,5.94 22.5,4.77 21.47,4.35M1.97,8.05L6.93,20C7.24,20.77 7.97,21.24 8.74,21.26C9,21.26 9.27,21.21 9.53,21.1L16.9,18.05C17.65,17.74 18.11,17 18.13,16.26C18.14,16 18.09,15.71 18,15.45L13,3.5C12.71,2.73 11.97,2.26 11.19,2.25C10.93,2.25 10.67,2.31 10.42,2.4L3.06,5.45C2.04,5.87 1.55,7.04 1.97,8.05M18.12,4.25A2,2 0 0,0 16.12,2.25H14.67L18.12,10.59' />
    </svg>", $text);
    
    if($class) {
      settings()->setExtraColumns(['classroom_id' => $class->id]);

      $text = str_replace('%GAME_NAME%', $class->adventure_name, $text);
      $text = str_replace('%GOLD_USE%', settings()->get('card_use', 200), $text);
      $text = str_replace('%GOLD_DELETE%', settings()->get('card_delete', 50), $text);
      $text = str_replace('%NUM_CARDS%', settings()->get('num_cards', 5), $text);

    }
  
    return $text;
  }

  /***
   * Returns the current class student
   */
  public static function getCurrentStudent($classroom, $with = ['equipment', 'classroom', 'behaviours', 'logEntries', 'items'])
  {
    return Student::where('id', '=', auth()->user()->classrooms
      ->where('pivot.classroom_id', '=', $classroom->id)
      ->where('pivot.role', '=', 0)
      ->first()
      ->pivot
      ->student->id)->with($with)->first();
  }

  /**
   * getRandomWeightedElement()
   * Utility function for getting random values with weighting.
   * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
   * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
   * The return value is the array key, A, B, or C in this case.  Note that the values assigned
   * do not have to be percentages.  The values are simply relative to each other.  If one value
   * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
   * chance of being selected.  Also note that weights should be integers.
   * 
   * @param array $weightedValues
   */
  public static function getRandomWeightedElement(array $weightedValues)
  {
    $rand = mt_rand(1, (int) array_sum($weightedValues));

    foreach ($weightedValues as $key => $value) {
      $rand -= $value;
      if ($rand <= 0) {
        return $key;
      }
    }
  }
}
