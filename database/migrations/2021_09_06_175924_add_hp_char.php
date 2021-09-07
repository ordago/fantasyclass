<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddHpChar extends Migration
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
                ['id' => '11', 'name' => 'Hp', 'classes' => 'hp'],
            ]
        );
        DB::table('characters')->insert(
            [
                ['id' => '43', 'name' => 'harry', 'character_theme_id' => '11', 'property' => '', 'classes' => 'harry'],
                ['id' => '44', 'name' => 'hermione', 'character_theme_id' => '11', 'property' => '', 'classes' => 'hermione'],
                ['id' => '45', 'name' => 'snape', 'character_theme_id' => '11', 'property' => '', 'classes' => 'snape'],
                ['id' => '46', 'name' => 'voldemort', 'character_theme_id' => '11', 'property' => '', 'classes' => 'voldemort'],
                ['id' => '47', 'name' => 'draco', 'character_theme_id' => '11', 'property' => '', 'classes' => 'draco'],
                ['id' => '48', 'name' => 'minerva', 'character_theme_id' => '11', 'property' => '', 'classes' => 'minerva'],
                ['id' => '49', 'name' => 'ron', 'character_theme_id' => '11', 'property' => '', 'classes' => 'ron'],
                ['id' => '50', 'name' => 'dumbledore', 'character_theme_id' => '11', 'property' => '', 'classes' => 'dumbledore'],
                
            ]
        );

        DB::table('equipment')->insert(
            [
                ['id' => '710', 'src' => 'hp/harry.png', 'offset' => '0', 'type' => '0', 'character_id' => '[43]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-head'],
                ['id' => '711', 'src' => 'hp/hermione.png', 'offset' => '0', 'type' => '0', 'character_id' => '[44]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-head'],
                ['id' => '712', 'src' => 'hp/snape.png', 'offset' => '0', 'type' => '0', 'character_id' => '[45]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-head'],
                ['id' => '713', 'src' => 'hp/voldemort.png', 'offset' => '0', 'type' => '0', 'character_id' => '[46]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-head'],
                ['id' => '714', 'src' => 'hp/draco.png', 'offset' => '0', 'type' => '0', 'character_id' => '[47]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-head'],
                ['id' => '715', 'src' => 'hp/minerva.png', 'offset' => '0', 'type' => '0', 'character_id' => '[48]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-head'],
                ['id' => '716', 'src' => 'hp/ron.png', 'offset' => '0', 'type' => '0', 'character_id' => '[49]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-head'],
                ['id' => '717', 'src' => 'hp/dumbledore.png', 'offset' => '0', 'type' => '0', 'character_id' => '[50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-head'],
                
                ['id' => '718', 'src' => 'hp/hands.png', 'offset' => '0', 'type' => '1', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-hands'],
                
                ['id' => '720', 'src' => 'hp/base_blue.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '721', 'src' => 'hp/base_gray.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '722', 'src' => 'hp/base_green.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '723', 'src' => 'hp/base_orange.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '724', 'src' => 'hp/base_purple.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '725', 'src' => 'hp/base_red.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '726', 'src' => 'hp/base_blue_2.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '727', 'src' => 'hp/base_gray_2.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '728', 'src' => 'hp/base_green_2.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '729', 'src' => 'hp/base_orange_2.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '730', 'src' => 'hp/base_purple_2.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                ['id' => '731', 'src' => 'hp/base_red_2.png', 'offset' => '0', 'type' => '2', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-base-shirt'],
                
                ['id' => '740', 'src' => 'hp/legs_blue.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '741', 'src' => 'hp/legs_gray.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '742', 'src' => 'hp/legs_green.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '743', 'src' => 'hp/legs_orange.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '744', 'src' => 'hp/legs_purple.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '745', 'src' => 'hp/legs_red.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '746', 'src' => 'hp/legs_blue_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '747', 'src' => 'hp/legs_gray_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '748', 'src' => 'hp/legs_green_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '749', 'src' => 'hp/legs_orange_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '750', 'src' => 'hp/legs_purple_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],
                ['id' => '751', 'src' => 'hp/legs_red_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-legs'],

                ['id' => '760', 'src' => 'hp/wand_0.png', 'offset' => '0', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-wand'],
                ['id' => '761', 'src' => 'hp/wand_1_xp.png', 'offset' => '1', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '200', 'classes' => 'hp-wand'],
                ['id' => '762', 'src' => 'hp/wand_1_gold.png', 'offset' => '1', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '200', 'classes' => 'hp-wand'],
                ['id' => '763', 'src' => 'hp/wand_1_hp.png', 'offset' => '1', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'hp-wand'],
                ['id' => '764', 'src' => 'hp/wand_2_xp.png', 'offset' => '2', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '10', 'gold' => '10', 'price' => '400', 'classes' => 'hp-wand'],
                ['id' => '765', 'src' => 'hp/wand_2_gold.png', 'offset' => '2', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '10', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'hp-wand'],
                ['id' => '766', 'src' => 'hp/wand_2_hp.png', 'offset' => '2', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '10', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'hp-wand'],
                ['id' => '767', 'src' => 'hp/wand_3_xp.png', 'offset' => '3', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '15', 'gold' => '15', 'price' => '600', 'classes' => 'hp-wand'],
                ['id' => '768', 'src' => 'hp/wand_3_gold.png', 'offset' => '3', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '600', 'classes' => 'hp-wand'],
                ['id' => '769', 'src' => 'hp/wand_3_hp.png', 'offset' => '3', 'type' => '4', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '15', 'xp' => '15', 'gold' => '0', 'price' => '600', 'classes' => 'hp-wand'],
        
                ['id' => '770', 'src' => 'hp/shirt_0.png', 'offset' => '0', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-shirt'],
                ['id' => '771', 'src' => 'hp/shirt_1_xp.png', 'offset' => '1', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '200', 'classes' => 'hp-shirt'],
                ['id' => '772', 'src' => 'hp/shirt_1_gold.png', 'offset' => '1', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '200', 'classes' => 'hp-shirt'],
                ['id' => '773', 'src' => 'hp/shirt_1_hp.png', 'offset' => '1', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'hp-shirt'],
                ['id' => '774', 'src' => 'hp/shirt_2_xp.png', 'offset' => '2', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '10', 'gold' => '10', 'price' => '400', 'classes' => 'hp-shirt'],
                ['id' => '775', 'src' => 'hp/shirt_2_gold.png', 'offset' => '2', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '10', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'hp-shirt'],
                ['id' => '776', 'src' => 'hp/shirt_2_hp.png', 'offset' => '2', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '10', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'hp-shirt'],
                ['id' => '777', 'src' => 'hp/shirt_3_xp.png', 'offset' => '3', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '15', 'gold' => '15', 'price' => '600', 'classes' => 'hp-shirt'],
                ['id' => '778', 'src' => 'hp/shirt_3_gold.png', 'offset' => '3', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '600', 'classes' => 'hp-shirt'],
                ['id' => '779', 'src' => 'hp/shirt_3_hp.png', 'offset' => '3', 'type' => '5', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '15', 'xp' => '15', 'gold' => '0', 'price' => '600', 'classes' => 'hp-shirt'],
                
                ['id' => '780', 'src' => 'hp/feet_0.png', 'offset' => '0', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'hp-feet'],
                ['id' => '781', 'src' => 'hp/feet_1_xp.png', 'offset' => '1', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '200', 'classes' => 'hp-feet'],
                ['id' => '782', 'src' => 'hp/feet_1_gold.png', 'offset' => '1', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '200', 'classes' => 'hp-feet'],
                ['id' => '783', 'src' => 'hp/feet_1_hp.png', 'offset' => '1', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'hp-feet'],
                ['id' => '784', 'src' => 'hp/feet_2_xp.png', 'offset' => '2', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '10', 'gold' => '10', 'price' => '400', 'classes' => 'hp-feet'],
                ['id' => '785', 'src' => 'hp/feet_2_gold.png', 'offset' => '2', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '10', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'hp-feet'],
                ['id' => '786', 'src' => 'hp/feet_2_hp.png', 'offset' => '2', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '10', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'hp-feet'],
                ['id' => '787', 'src' => 'hp/feet_3_xp.png', 'offset' => '3', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '0', 'xp' => '15', 'gold' => '15', 'price' => '600', 'classes' => 'hp-feet'],
                ['id' => '788', 'src' => 'hp/feet_3_gold.png', 'offset' => '3', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '600', 'classes' => 'hp-feet'],
                ['id' => '789', 'src' => 'hp/feet_3_hp.png', 'offset' => '3', 'type' => '6', 'character_id' => '[43, 44, 45, 46, 47, 48, 49, 50]', 'hp' => '15', 'xp' => '15', 'gold' => '0', 'price' => '600', 'classes' => 'hp-feet'],

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
