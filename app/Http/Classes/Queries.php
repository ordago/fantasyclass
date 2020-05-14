<?php

namespace App\Http\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Queries
{
    public static function getBg($id = null, $ui = false)
    {
      if(!$id)
        $theme = DB::table('themes')->where('id', '>=', 17)->inRandomOrder()->first();
      else 
        $theme = DB::table('themes')->where('id', '=', $id)->first();

        if($theme->type == 0)
          return " style='background-color:".$theme->color.";'";
        
          return " style='background: url(/img/bg/".$theme->name."); background-color:".$theme->color."; background-position: center bottom;background-size: 100%; background-attachment: fixed;background-repeat: no-repeat;'";

       /* $theme = Queries::getPropertyValue('students_theme');
        if ($theme) {
            $theme = DB::table('themes')->where('id', $theme)->first();
            if ($ui) {
                $bgsize = "";
            } else {
                $bgsize = "background-size: 100% auto;";
            }
            if ($theme->type == 0) {
                return " style='background-color:".$theme->color."'";
            } else {
            }
        }
        return null;*/
    }

    /*
    public static function getPropertyValue($name, $type = "settings_num")
    {
      $value = DB::table($type)->where('property_name', $name)->first();
      if ($value) {
        return $value->property_value;
      } else {
        return null;
      }
    }

    public static function getIconsDirectories()
    {
      $array = array_diff(scandir('../public/icon-packs'), array('..', '.'));
      return $array;

    }

    function getGameName() {
        return Queries::getPropertyValue('game_name', 'settings_text');
    }
    */
}
