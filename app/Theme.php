<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public static function getBg($id = null, $ui = false)
    {
        if(!$id)
            $theme = Theme::where('id', '>', 17)->inRandomOrder()->first();
        else
            $theme = Theme::where('id', '=', $id)->first();

        if($theme->type == 0)
          return " style='background-color:".$theme->color.";'";
        
          return " style='background: url(/img/bg/".$theme->name    ."); background-color:".$theme->color."; background-position: left bottom; background-size: cover; background-attachment: fixed;background-repeat: no-repeat;'";
    }

}
