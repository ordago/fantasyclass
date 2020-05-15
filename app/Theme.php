<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public static function getBg($id = null, $ui = false)
    {

        $theme = Theme::where('id', '>', 17)->inRandomOrder()->first();
        
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

}
