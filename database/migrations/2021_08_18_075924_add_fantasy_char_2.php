<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFantasyChar2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   
        DB::table('characters')->insert(
            [
                ['id' => '30', 'name' => 'fairy', 'character_theme_id' => '7', 'property' => 'fas fa-fist-raised', 'classes' => 'fly'],
                ['id' => '31', 'name' => 'mummy', 'character_theme_id' => '7', 'property' => 'fas fa-coins', 'classes' => NULL],
                ['id' => '32', 'name' => 'golem', 'character_theme_id' => '7', 'property' => 'fas fa-heart', 'classes' => NULL],
            ]
        );

        DB::table('equipment')->insert(
            [
                // fairy
                ['id' => '580', 'src' => 'fantasy/fairy_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '30', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'fairy-body'],
                ['id' => '581', 'src' => 'fantasy/fairy_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '30', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'fairy-body'],
                ['id' => '582', 'src' => 'fantasy/fairy_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '30', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'fairy-body'],
                ['id' => '583', 'src' => 'fantasy/fairy_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '30', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'fairy-body'],

                ['id' => '584', 'src' => 'fantasy/fairy_wings_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '30', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'fairy-wings'],
                ['id' => '585', 'src' => 'fantasy/fairy_wings_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '30', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'fairy-wings'],
                ['id' => '586', 'src' => 'fantasy/fairy_wings_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '30', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'fairy-wings'],
                ['id' => '587', 'src' => 'fantasy/fairy_wings_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '30', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '1000', 'classes' => 'fairy-wings'],

                ['id' => '588', 'src' => 'fantasy/fairy_wand_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '30', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'fairy-wand'],
                ['id' => '589', 'src' => 'fantasy/fairy_wand_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '30', 'hp' => '0', 'xp' => '15', 'gold' => '5', 'price' => '700', 'classes' => 'fairy-wand'],
                ['id' => '590', 'src' => 'fantasy/fairy_wand_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '30', 'hp' => '5', 'xp' => '15', 'gold' => '10', 'price' => '1400', 'classes' => 'fairy-wand'],
                ['id' => '591', 'src' => 'fantasy/fairy_wand_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '30', 'hp' => '15', 'xp' => '20', 'gold' => '20', 'price' => '2000', 'classes' => 'fairy-wand'],

                ['id' => '592', 'src' => 'fantasy/fairy_ball_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '30', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'fairy-ball'],
                ['id' => '593', 'src' => 'fantasy/fairy_ball_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '30', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'fairy-ball'],
                ['id' => '594', 'src' => 'fantasy/fairy_ball_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '30', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '400', 'classes' => 'fairy-ball'],
                ['id' => '595', 'src' => 'fantasy/fairy_ball_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '30', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'fairy-ball'],
                
                // mummy
                ['id' => '600', 'src' => 'fantasy/mummy_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '31', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'mummy-body'],
                ['id' => '601', 'src' => 'fantasy/mummy_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '31', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'mummy-body'],
                ['id' => '602', 'src' => 'fantasy/mummy_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '31', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'mummy-body'],
                ['id' => '603', 'src' => 'fantasy/mummy_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '31', 'hp' => '10', 'xp' => '10', 'gold' => '15', 'price' => '600', 'classes' => 'mummy-body'],

                ['id' => '604', 'src' => 'fantasy/mummy_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '31', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'mummy-head'],
                ['id' => '605', 'src' => 'fantasy/mummy_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '31', 'hp' => '0', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'mummy-head'],
                ['id' => '606', 'src' => 'fantasy/mummy_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '31', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '800', 'classes' => 'mummy-head'],
                ['id' => '607', 'src' => 'fantasy/mummy_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '31', 'hp' => '15', 'xp' => '10', 'gold' => '15', 'price' => '1000', 'classes' => 'mummy-head'],

                ['id' => '608', 'src' => 'fantasy/mummy_weapon_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '31', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'mummy-weapon'],
                ['id' => '609', 'src' => 'fantasy/mummy_weapon_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '31', 'hp' => '0', 'xp' => '5', 'gold' => '15', 'price' => '700', 'classes' => 'mummy-weapon'],
                ['id' => '610', 'src' => 'fantasy/mummy_weapon_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '31', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1400', 'classes' => 'mummy-weapon'],
                ['id' => '611', 'src' => 'fantasy/mummy_weapon_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '31', 'hp' => '15', 'xp' => '20', 'gold' => '20', 'price' => '2000', 'classes' => 'mummy-weapon'],

                ['id' => '612', 'src' => 'fantasy/mummy_shield_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '31', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'mummy-shield'],
                ['id' => '613', 'src' => 'fantasy/mummy_shield_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '31', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'mummy-shield'],
                ['id' => '614', 'src' => 'fantasy/mummy_shield_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '31', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '400', 'classes' => 'mummy-shield'],
                ['id' => '615', 'src' => 'fantasy/mummy_shield_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '31', 'hp' => '10', 'xp' => '10', 'gold' => '15', 'price' => '600', 'classes' => 'mummy-shield'],
                
                // golem
                ['id' => '620', 'src' => 'fantasy/golem_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '32', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'golem-body'],
                ['id' => '621', 'src' => 'fantasy/golem_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '32', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'golem-body'],
                ['id' => '622', 'src' => 'fantasy/golem_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '32', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'golem-body'],
                ['id' => '623', 'src' => 'fantasy/golem_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '32', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'golem-body'],

                ['id' => '624', 'src' => 'fantasy/golem_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '32', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'golem-head'],
                ['id' => '625', 'src' => 'fantasy/golem_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '32', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '400', 'classes' => 'golem-head'],
                ['id' => '626', 'src' => 'fantasy/golem_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '32', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'golem-head'],
                ['id' => '627', 'src' => 'fantasy/golem_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '32', 'hp' => '15', 'xp' => '10', 'gold' => '10', 'price' => '1000', 'classes' => 'golem-head'],

                ['id' => '628', 'src' => 'fantasy/golem_weapon_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '32', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'golem-weapon'],
                ['id' => '629', 'src' => 'fantasy/golem_weapon_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '32', 'hp' => '15', 'xp' => '0', 'gold' => '5', 'price' => '700', 'classes' => 'golem-weapon'],
                ['id' => '630', 'src' => 'fantasy/golem_weapon_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '32', 'hp' => '15', 'xp' => '5', 'gold' => '10', 'price' => '1400', 'classes' => 'golem-weapon'],
                ['id' => '631', 'src' => 'fantasy/golem_weapon_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '32', 'hp' => '20', 'xp' => '15', 'gold' => '20', 'price' => '2000', 'classes' => 'golem-weapon'],

                ['id' => '632', 'src' => 'fantasy/golem_bottom_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '32', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'golem-bottom'],
                ['id' => '633', 'src' => 'fantasy/golem_bottom_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '32', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'golem-bottom'],
                ['id' => '634', 'src' => 'fantasy/golem_bottom_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '32', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'golem-bottom'],
                ['id' => '635', 'src' => 'fantasy/golem_bottom_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '32', 'hp' => '15', 'xp' => '10', 'gold' => '10', 'price' => '600', 'classes' => 'golem-bottom'],
                

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
