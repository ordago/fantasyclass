<?php

namespace App\Http\Classes;

use App\Student;
use Google_Service_Drive_AboutDriveThemes;

class Functions
{

  public static function getProbability($success) {
    $v = rand(0, 99);
    if($v < $success) {
      return true;
    } return false;
  }
  /***
   * Replace special chars
   */
  public static function replaceSpecial($text, $class = null)
  {
    // $text = str_replace('[tex]', '\[', $text);
    // $text = str_replace('[/tex]', '\]', $text);
    $text = str_replace('%XP%', "<i class='fas fa-fist-raised colored'></i>", $text);
    $text = str_replace('%GOLD%', "<i class='fas fa-coins colored'></i>", $text);
    $text = str_replace('%HP%', "<i class='fas fa-heart colored'></i>", $text);
    $text = str_replace('%BR%', "<br>", $text);
    $text = str_replace('%br%', "<br>", $text);

    if ($class) {
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
  public static function getCurrentStudent($classroom, $with = ['equipment', 'classroom', 'behaviours', 'logEntries', 'items', 'grades.tags'])
  {
    if (session()->get('bypass_student')) {
      $student = Student::where('id', '=', session()->get('bypass_student'))->with($with)->first();
      if($student->classroom->classroom_id == $classroom->id)
        return $student;
      abort(403);
    }

    $class = auth()->user()->classrooms
      ->where('pivot.classroom_id', '=', $classroom->id)
      ->where('pivot.role', '=', 0)
      ->first();

    if($class) {
      return Student::where(
        'id',
        '=',
        $class->pivot->student->id
      )->with($with)->first();
    }
    abort(403);
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
