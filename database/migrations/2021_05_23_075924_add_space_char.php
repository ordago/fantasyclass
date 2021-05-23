<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddSpaceChar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('character_themes')->insert(
            [
                ['id' => '9', 'name' => 'Space', 'classes' => NULL],
            ]
        );
        DB::table('characters')->insert(
            [
                ['id' => '27', 'name' => 'a1', 'character_theme_id' => '9', 'property' => 'fas fa-fist-raised', 'classes' => 'fly'],
                ['id' => '28', 'name' => 'a2', 'character_theme_id' => '9', 'property' => 'fas fa-coins', 'classes' => 'fly'],
                ['id' => '29', 'name' => 'a3', 'character_theme_id' => '9', 'property' => 'fas fa-heart', 'classes' => 'fly'],
            ]
        );

        DB::table('equipment')->insert(
            [
                // a1
                ['id' => '520','src' => 'space/a1_cape_0.png', 'offset' => '0', 'type' => '0','character_id' => '27','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a1-cape'],
                ['id' => '521','src' => 'space/a1_cape_1.png', 'offset' => '1', 'type' => '0','character_id' => '27','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'is-absolute a1-cape'],
                ['id' => '522','src' => 'space/a1_cape_2.png', 'offset' => '2', 'type' => '0','character_id' => '27','hp' => '5','xp' => '10','gold' => '15','price' => '1000', 'classes' => 'is-absolute a1-cape'],
                ['id' => '523','src' => 'space/a1_cape_3.png', 'offset' => '3', 'type' => '0','character_id' => '27','hp' => '15','xp' => '20','gold' => '10','price' => '1200', 'classes' => 'is-absolute a1-cape'],
                ['id' => '524','src' => 'space/a1_body_0.png', 'offset' => '0', 'type' => '1','character_id' => '27','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a1-body'],
                ['id' => '525','src' => 'space/a1_body_1.png', 'offset' => '1', 'type' => '1','character_id' => '27','hp' => '0','xp' => '5','gold' => '15','price' => '700', 'classes' => 'is-absolute a1-body'],
                ['id' => '526','src' => 'space/a1_body_2.png', 'offset' => '2', 'type' => '1','character_id' => '27','hp' => '10','xp' => '5','gold' => '15','price' => '800', 'classes' => 'is-absolute a1-body'],
                ['id' => '527','src' => 'space/a1_body_3.png', 'offset' => '3', 'type' => '1','character_id' => '27','hp' => '15','xp' => '20','gold' => '10','price' => '1200', 'classes' => 'is-absolute a1-body'],
                ['id' => '528','src' => 'space/a1_head_0.png', 'offset' => '0', 'type' => '2','character_id' => '27','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a1-head'],
                ['id' => '529','src' => 'space/a1_head_1.png', 'offset' => '1', 'type' => '2','character_id' => '27','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'is-absolute a1-head'],
                ['id' => '530','src' => 'space/a1_head_2.png', 'offset' => '2', 'type' => '2','character_id' => '27','hp' => '10','xp' => '10','gold' => '10','price' => '800', 'classes' => 'is-absolute a1-head'],
                ['id' => '531','src' => 'space/a1_head_3.png', 'offset' => '3', 'type' => '2','character_id' => '27','hp' => '20','xp' => '40','gold' => '20','price' => '1600', 'classes' => 'is-absolute a1-head'],
               
                // a2
                ['id' => '540','src' => 'space/a2_cape_0.png', 'offset' => '0', 'type' => '0','character_id' => '28','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a2-cape'],
                ['id' => '541','src' => 'space/a2_cape_1.png', 'offset' => '1', 'type' => '0','character_id' => '28','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'is-absolute a2-cape'],
                ['id' => '542','src' => 'space/a2_cape_2.png', 'offset' => '2', 'type' => '0','character_id' => '28','hp' => '15','xp' => '5','gold' => '10','price' => '1000', 'classes' => 'is-absolute a2-cape'],
                ['id' => '543','src' => 'space/a2_cape_3.png', 'offset' => '3', 'type' => '0','character_id' => '28','hp' => '10','xp' => '15','gold' => '20','price' => '1200', 'classes' => 'is-absolute a2-cape'],
                ['id' => '544','src' => 'space/a2_body_0.png', 'offset' => '0', 'type' => '1','character_id' => '28','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a2-body'],
                ['id' => '545','src' => 'space/a2_body_1.png', 'offset' => '1', 'type' => '1','character_id' => '28','hp' => '15','xp' => '0','gold' => '5','price' => '700', 'classes' => 'is-absolute a2-body'],
                ['id' => '546','src' => 'space/a2_body_2.png', 'offset' => '2', 'type' => '1','character_id' => '28','hp' => '15','xp' => '10','gold' => '5','price' => '800', 'classes' => 'is-absolute a2-body'],
                ['id' => '547','src' => 'space/a2_body_3.png', 'offset' => '3', 'type' => '1','character_id' => '28','hp' => '10','xp' => '15','gold' => '20','price' => '1200', 'classes' => 'is-absolute a2-body'],
                ['id' => '548','src' => 'space/a2_head_0.png', 'offset' => '0', 'type' => '2','character_id' => '28','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a2-head'],
                ['id' => '549','src' => 'space/a2_head_1.png', 'offset' => '1', 'type' => '2','character_id' => '28','hp' => '5','xp' => '5','gold' => '0','price' => '400', 'classes' => 'is-absolute a2-head'],
                ['id' => '550','src' => 'space/a2_head_2.png', 'offset' => '2', 'type' => '2','character_id' => '28','hp' => '10','xp' => '10','gold' => '10','price' => '800', 'classes' => 'is-absolute a2-head'],
                ['id' => '551','src' => 'space/a2_head_3.png', 'offset' => '3', 'type' => '2','character_id' => '28','hp' => '20','xp' => '20','gold' => '40','price' => '1600', 'classes' => 'is-absolute a2-head'],
                
                //a3
                ['id' => '560','src' => 'space/a3_cape_0.png', 'offset' => '0', 'type' => '0','character_id' => '29','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a3-cape'],
                ['id' => '561','src' => 'space/a3_cape_1.png', 'offset' => '1', 'type' => '0','character_id' => '29','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'is-absolute a3-cape'],
                ['id' => '562','src' => 'space/a3_cape_2.png', 'offset' => '2', 'type' => '0','character_id' => '29','hp' => '10','xp' => '5','gold' => '15','price' => '1000', 'classes' => 'is-absolute a3-cape'],
                ['id' => '563','src' => 'space/a3_cape_3.png', 'offset' => '3', 'type' => '0','character_id' => '29','hp' => '20','xp' => '15','gold' => '10','price' => '1200', 'classes' => 'is-absolute a3-cape'],
                ['id' => '564','src' => 'space/a3_body_0.png', 'offset' => '0', 'type' => '1','character_id' => '29','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a3-body'],
                ['id' => '565','src' => 'space/a3_body_1.png', 'offset' => '1', 'type' => '1','character_id' => '29','hp' => '5','xp' => '0','gold' => '15','price' => '700', 'classes' => 'is-absolute a3-body'],
                ['id' => '566','src' => 'space/a3_body_2.png', 'offset' => '2', 'type' => '1','character_id' => '29','hp' => '5','xp' => '10','gold' => '15','price' => '800', 'classes' => 'is-absolute a3-body'],
                ['id' => '567','src' => 'space/a3_body_3.png', 'offset' => '3', 'type' => '1','character_id' => '29','hp' => '20','xp' => '15','gold' => '10','price' => '1200', 'classes' => 'is-absolute a3-body'],
                ['id' => '568','src' => 'space/a3_head_0.png', 'offset' => '0', 'type' => '2','character_id' => '29','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'is-absolute a3-head'],
                ['id' => '569','src' => 'space/a3_head_1.png', 'offset' => '1', 'type' => '2','character_id' => '29','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'is-absolute a3-head'],
                ['id' => '570','src' => 'space/a3_head_2.png', 'offset' => '2', 'type' => '2','character_id' => '29','hp' => '10','xp' => '10','gold' => '10','price' => '800', 'classes' => 'is-absolute a3-head'],
                ['id' => '571','src' => 'space/a3_head_3.png', 'offset' => '3', 'type' => '2','character_id' => '29','hp' => '40','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'is-absolute a3-head'],
                

                ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
