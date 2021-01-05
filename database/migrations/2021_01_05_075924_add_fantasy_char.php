<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFantasyChar extends Migration
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
                ['id' => '7', 'name' => 'Fantasy', 'classes' => NULL],
            ]
        );
        DB::table('characters')->insert(
            [
                ['id' => '23', 'name' => 'archer', 'character_theme_id' => '7', 'property' => 'fas fa-fist-raised', 'classes' => NULL],
                ['id' => '24', 'name' => 'wizard', 'character_theme_id' => '7', 'property' => 'fas fa-coins', 'classes' => 'fly'],
                ['id' => '25', 'name' => 'knight', 'character_theme_id' => '7', 'property' => 'fas fa-heart', 'classes' => NULL],
            ]
        );

        DB::table('equipment')->insert(
            [
                // Archer
                ['id' => '450', 'src' => 'fantasy/archer_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '23', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'archer-body'],
                ['id' => '451', 'src' => 'fantasy/archer_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '23', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'archer-body'],
                ['id' => '452', 'src' => 'fantasy/archer_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '23', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'archer-body'],
                ['id' => '453', 'src' => 'fantasy/archer_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '23', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'archer-body'],

                ['id' => '454', 'src' => 'fantasy/archer_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '23', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'archer-head'],
                ['id' => '455', 'src' => 'fantasy/archer_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '23', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'archer-head'],
                ['id' => '456', 'src' => 'fantasy/archer_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '23', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'archer-head'],
                ['id' => '457', 'src' => 'fantasy/archer_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '23', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '1000', 'classes' => 'archer-head'],

                ['id' => '458', 'src' => 'fantasy/archer_bow_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '23', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'archer-bow'],
                ['id' => '459', 'src' => 'fantasy/archer_bow_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '23', 'hp' => '0', 'xp' => '15', 'gold' => '5', 'price' => '700', 'classes' => 'archer-bow'],
                ['id' => '460', 'src' => 'fantasy/archer_bow_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '23', 'hp' => '5', 'xp' => '15', 'gold' => '10', 'price' => '1400', 'classes' => 'archer-bow'],
                ['id' => '461', 'src' => 'fantasy/archer_bow_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '23', 'hp' => '15', 'xp' => '20', 'gold' => '20', 'price' => '2000', 'classes' => 'archer-bow'],

                ['id' => '462', 'src' => 'fantasy/archer_arrow_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '23', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'archer-arrow'],
                ['id' => '463', 'src' => 'fantasy/archer_arrow_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '23', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'archer-arrow'],
                ['id' => '464', 'src' => 'fantasy/archer_arrow_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '23', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '400', 'classes' => 'archer-arrow'],
                ['id' => '465', 'src' => 'fantasy/archer_arrow_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '23', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'archer-arrow'],
                
                // Wizard
                ['id' => '470', 'src' => 'fantasy/wraith_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '24', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'wraith-body'],
                ['id' => '471', 'src' => 'fantasy/wraith_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '24', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'wraith-body'],
                ['id' => '472', 'src' => 'fantasy/wraith_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '24', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'wraith-body'],
                ['id' => '473', 'src' => 'fantasy/wraith_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '24', 'hp' => '10', 'xp' => '10', 'gold' => '15', 'price' => '600', 'classes' => 'wraith-body'],

                ['id' => '474', 'src' => 'fantasy/wraith_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '24', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'wraith-head'],
                ['id' => '475', 'src' => 'fantasy/wraith_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '24', 'hp' => '0', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'wraith-head'],
                ['id' => '476', 'src' => 'fantasy/wraith_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '24', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '800', 'classes' => 'wraith-head'],
                ['id' => '477', 'src' => 'fantasy/wraith_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '24', 'hp' => '15', 'xp' => '10', 'gold' => '15', 'price' => '1000', 'classes' => 'wraith-head'],

                ['id' => '478', 'src' => 'fantasy/wraith_ball_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '24', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'wraith-ball'],
                ['id' => '479', 'src' => 'fantasy/wraith_ball_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '24', 'hp' => '0', 'xp' => '5', 'gold' => '15', 'price' => '700', 'classes' => 'wraith-ball'],
                ['id' => '480', 'src' => 'fantasy/wraith_ball_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '24', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1400', 'classes' => 'wraith-ball'],
                ['id' => '481', 'src' => 'fantasy/wraith_ball_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '24', 'hp' => '15', 'xp' => '20', 'gold' => '20', 'price' => '2000', 'classes' => 'wraith-ball'],

                ['id' => '482', 'src' => 'fantasy/wraith_arms_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '24', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'wraith-arms'],
                ['id' => '483', 'src' => 'fantasy/wraith_arms_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '24', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'wraith-arms'],
                ['id' => '484', 'src' => 'fantasy/wraith_arms_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '24', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '400', 'classes' => 'wraith-arms'],
                ['id' => '485', 'src' => 'fantasy/wraith_arms_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '24', 'hp' => '10', 'xp' => '10', 'gold' => '15', 'price' => '600', 'classes' => 'wraith-arms'],
                
                // Knight
                ['id' => '490', 'src' => 'fantasy/knight_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '25', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'knight-body'],
                ['id' => '491', 'src' => 'fantasy/knight_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '25', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'knight-body'],
                ['id' => '492', 'src' => 'fantasy/knight_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '25', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'knight-body'],
                ['id' => '493', 'src' => 'fantasy/knight_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '25', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'knight-body'],

                ['id' => '494', 'src' => 'fantasy/knight_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '25', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'knight-head'],
                ['id' => '495', 'src' => 'fantasy/knight_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '25', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '400', 'classes' => 'knight-head'],
                ['id' => '496', 'src' => 'fantasy/knight_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '25', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'knight-head'],
                ['id' => '497', 'src' => 'fantasy/knight_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '25', 'hp' => '15', 'xp' => '10', 'gold' => '10', 'price' => '1000', 'classes' => 'knight-head'],

                ['id' => '498', 'src' => 'fantasy/knight_sword_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '25', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'knight-sword'],
                ['id' => '499', 'src' => 'fantasy/knight_sword_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '25', 'hp' => '15', 'xp' => '0', 'gold' => '5', 'price' => '700', 'classes' => 'knight-sword'],
                ['id' => '500', 'src' => 'fantasy/knight_sword_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '25', 'hp' => '15', 'xp' => '5', 'gold' => '10', 'price' => '1400', 'classes' => 'knight-sword'],
                ['id' => '501', 'src' => 'fantasy/knight_sword_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '25', 'hp' => '20', 'xp' => '15', 'gold' => '20', 'price' => '2000', 'classes' => 'knight-sword'],

                ['id' => '502', 'src' => 'fantasy/knight_shield_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '25', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'knight-shield'],
                ['id' => '503', 'src' => 'fantasy/knight_shield_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '25', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'knight-shield'],
                ['id' => '504', 'src' => 'fantasy/knight_shield_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '25', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'knight-shield'],
                ['id' => '505', 'src' => 'fantasy/knight_shield_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '25', 'hp' => '15', 'xp' => '10', 'gold' => '10', 'price' => '600', 'classes' => 'knight-shield'],
                

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
