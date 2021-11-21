<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddGladiatorChar extends Migration
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
                ['id' => '13', 'name' => 'Gladiator', 'classes' => 'gladiator character-small'],
            ]
        );
        DB::table('characters')->insert(
            [
                ['id' => '57', 'name' => 'm1', 'character_theme_id' => '13', 'property' => '', 'classes' => ''],
                ['id' => '58', 'name' => 'm2', 'character_theme_id' => '13', 'property' => '', 'classes' => ''],
                ['id' => '59', 'name' => 'm3', 'character_theme_id' => '13', 'property' => '', 'classes' => ''],
                ['id' => '60', 'name' => 'f1', 'character_theme_id' => '13', 'property' => '', 'classes' => ''],
                ['id' => '61', 'name' => 'f2', 'character_theme_id' => '13', 'property' => '', 'classes' => ''],
                ['id' => '62', 'name' => 'f3', 'character_theme_id' => '13', 'property' => '', 'classes' => ''],
            ]
        );

        DB::table('equipment')->insert(
            [
                ['id' => '1000', 'src' => 'gladiators/body_m_1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[57]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-body'],
                ['id' => '1001', 'src' => 'gladiators/body_m_2.png', 'offset' => '0', 'type' => '0', 'character_id' => '[58]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-body'],
                ['id' => '1002', 'src' => 'gladiators/body_m_3.png', 'offset' => '0', 'type' => '0', 'character_id' => '[59]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-body'],
                ['id' => '1003', 'src' => 'gladiators/body_w_1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[60]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-body'],
                ['id' => '1004', 'src' => 'gladiators/body_w_2.png', 'offset' => '0', 'type' => '0', 'character_id' => '[61]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-body'],
                ['id' => '1005', 'src' => 'gladiators/body_w_3.png', 'offset' => '0', 'type' => '0', 'character_id' => '[62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-body'],
          
                ['id' => '1010', 'src' => 'gladiators/boots_0_1.png', 'offset' => '0', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-boots'],
                ['id' => '1011', 'src' => 'gladiators/boots_0_2.png', 'offset' => '0', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-boots'],
                ['id' => '1012', 'src' => 'gladiators/boots_0_3.png', 'offset' => '0', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-boots'],
                ['id' => '1013', 'src' => 'gladiators/boots_0_4.png', 'offset' => '0', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-boots'],
                ['id' => '1014', 'src' => 'gladiators/boots_1_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '2', 'gold' => '2', 'price' => '100', 'classes' => 'gladiator-boots'],
                ['id' => '1015', 'src' => 'gladiators/boots_1_2.png', 'offset' => '1', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '2', 'gold' => '2', 'price' => '100', 'classes' => 'gladiator-boots'],
                ['id' => '1016', 'src' => 'gladiators/boots_1_3.png', 'offset' => '1', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '2', 'gold' => '2', 'price' => '100', 'classes' => 'gladiator-boots'],
                ['id' => '1017', 'src' => 'gladiators/boots_1_4.png', 'offset' => '1', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '2', 'gold' => '2', 'price' => '100', 'classes' => 'gladiator-boots'],
                ['id' => '1018', 'src' => 'gladiators/boots_2_1.png', 'offset' => '2', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '4', 'gold' => '4', 'price' => '200', 'classes' => 'gladiator-boots'],
                ['id' => '1019', 'src' => 'gladiators/boots_2_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '4', 'gold' => '4', 'price' => '200', 'classes' => 'gladiator-boots'],
                ['id' => '1020', 'src' => 'gladiators/boots_2_3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '4', 'gold' => '4', 'price' => '200', 'classes' => 'gladiator-boots'],
                ['id' => '1021', 'src' => 'gladiators/boots_2_4.png', 'offset' => '2', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '4', 'gold' => '4', 'price' => '200', 'classes' => 'gladiator-boots'],
                ['id' => '1022', 'src' => 'gladiators/boots_3_1.png', 'offset' => '3', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '8', 'gold' => '8', 'price' => '400', 'classes' => 'gladiator-boots'],
                ['id' => '1023', 'src' => 'gladiators/boots_3_2.png', 'offset' => '3', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '8', 'gold' => '8', 'price' => '400', 'classes' => 'gladiator-boots'],
                ['id' => '1024', 'src' => 'gladiators/boots_3_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '8', 'gold' => '8', 'price' => '400', 'classes' => 'gladiator-boots'],
                ['id' => '1025', 'src' => 'gladiators/boots_3_4.png', 'offset' => '3', 'type' => '1', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '8', 'gold' => '8', 'price' => '400', 'classes' => 'gladiator-boots'],

                ['id' => '1030', 'src' => 'gladiators/helmet_0_1.png', 'offset' => '0', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-helmet'],
                ['id' => '1031', 'src' => 'gladiators/helmet_0_2.png', 'offset' => '0', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-helmet-big'],
                ['id' => '1032', 'src' => 'gladiators/helmet_0_3.png', 'offset' => '0', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-helmet'],
                ['id' => '1033', 'src' => 'gladiators/helmet_0_4.png', 'offset' => '0', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-helmet'],
                ['id' => '1034', 'src' => 'gladiators/helmet_1_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '3', 'gold' => '5', 'price' => '200', 'classes' => 'gladiator-helmet-big'],
                ['id' => '1035', 'src' => 'gladiators/helmet_1_2.png', 'offset' => '1', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '3', 'gold' => '5', 'price' => '200', 'classes' => 'gladiator-helmet'],
                ['id' => '1036', 'src' => 'gladiators/helmet_1_3.png', 'offset' => '1', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '2', 'gold' => '5', 'price' => '200', 'classes' => 'gladiator-helmet'],
                ['id' => '1037', 'src' => 'gladiators/helmet_1_4.png', 'offset' => '1', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '2', 'gold' => '5', 'price' => '200', 'classes' => 'gladiator-helmet'],
                ['id' => '1038', 'src' => 'gladiators/helmet_2_1.png', 'offset' => '2', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '6', 'gold' => '10', 'price' => '400', 'classes' => 'gladiator-helmet'],
                ['id' => '1039', 'src' => 'gladiators/helmet_2_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '6', 'gold' => '10', 'price' => '400', 'classes' => 'gladiator-helmet'],
                ['id' => '1040', 'src' => 'gladiators/helmet_2_3.png', 'offset' => '2', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '4', 'gold' => '10', 'price' => '400', 'classes' => 'gladiator-helmet'],
                ['id' => '1041', 'src' => 'gladiators/helmet_2_4.png', 'offset' => '2', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '4', 'gold' => '10', 'price' => '400', 'classes' => 'gladiator-helmet'],
                ['id' => '1042', 'src' => 'gladiators/helmet_3_1.png', 'offset' => '3', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '12', 'gold' => '20', 'price' => '800', 'classes' => 'gladiator-helmet'],
                ['id' => '1043', 'src' => 'gladiators/helmet_3_2.png', 'offset' => '3', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '12', 'gold' => '20', 'price' => '800', 'classes' => 'gladiator-helmet'],
                ['id' => '1044', 'src' => 'gladiators/helmet_3_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '8', 'gold' => '20', 'price' => '800', 'classes' => 'gladiator-helmet'],
                ['id' => '1045', 'src' => 'gladiators/helmet_3_4.png', 'offset' => '3', 'type' => '2', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '8', 'gold' => '20', 'price' => '800', 'classes' => 'gladiator-helmet'],

                ['id' => '1050', 'src' => 'gladiators/shield_0_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-shield'],
                ['id' => '1051', 'src' => 'gladiators/shield_0_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-shield'],
                ['id' => '1052', 'src' => 'gladiators/shield_0_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-shield'],
                ['id' => '1053', 'src' => 'gladiators/shield_0_4.png', 'offset' => '0', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-shield'],
                ['id' => '1054', 'src' => 'gladiators/shield_1_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '5', 'xp' => '3', 'gold' => '2', 'price' => '200', 'classes' => 'gladiator-shield'],
                ['id' => '1055', 'src' => 'gladiators/shield_1_2.png', 'offset' => '1', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '5', 'xp' => '3', 'gold' => '2', 'price' => '200', 'classes' => 'gladiator-shield'],
                ['id' => '1056', 'src' => 'gladiators/shield_1_3.png', 'offset' => '1', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '5', 'xp' => '2', 'gold' => '3', 'price' => '200', 'classes' => 'gladiator-shield'],
                ['id' => '1057', 'src' => 'gladiators/shield_1_4.png', 'offset' => '1', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '5', 'xp' => '2', 'gold' => '3', 'price' => '200', 'classes' => 'gladiator-shield'],
                ['id' => '1058', 'src' => 'gladiators/shield_2_1.png', 'offset' => '2', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '10', 'xp' => '6', 'gold' => '4', 'price' => '400', 'classes' => 'gladiator-shield'],
                ['id' => '1059', 'src' => 'gladiators/shield_2_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '10', 'xp' => '6', 'gold' => '4', 'price' => '400', 'classes' => 'gladiator-shield'],
                ['id' => '1060', 'src' => 'gladiators/shield_2_3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '10', 'xp' => '4', 'gold' => '6', 'price' => '400', 'classes' => 'gladiator-shield'],
                ['id' => '1061', 'src' => 'gladiators/shield_2_4.png', 'offset' => '2', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '10', 'xp' => '4', 'gold' => '6', 'price' => '400', 'classes' => 'gladiator-shield'],
                ['id' => '1062', 'src' => 'gladiators/shield_3_1.png', 'offset' => '3', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '20', 'xp' => '12', 'gold' => '8', 'price' => '800', 'classes' => 'gladiator-shield'],
                ['id' => '1063', 'src' => 'gladiators/shield_3_2.png', 'offset' => '3', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '20', 'xp' => '12', 'gold' => '8', 'price' => '800', 'classes' => 'gladiator-shield'],
                ['id' => '1064', 'src' => 'gladiators/shield_3_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '20', 'xp' => '8', 'gold' => '12', 'price' => '800', 'classes' => 'gladiator-shield'],
                ['id' => '1065', 'src' => 'gladiators/shield_3_4.png', 'offset' => '3', 'type' => '3', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '20', 'xp' => '8', 'gold' => '12', 'price' => '800', 'classes' => 'gladiator-shield'],
                
                ['id' => '1070', 'src' => 'gladiators/bow_0_1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-bow'],
                ['id' => '1071', 'src' => 'gladiators/bow_0_2.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-bow'],
                ['id' => '1072', 'src' => 'gladiators/bow_0_3.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-bow'],
                ['id' => '1073', 'src' => 'gladiators/bow_0_4.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-bow'],
                ['id' => '1074', 'src' => 'gladiators/bow_1_1.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '5', 'gold' => '2', 'price' => '400', 'classes' => 'gladiator-bow'],
                ['id' => '1075', 'src' => 'gladiators/bow_1_2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '5', 'gold' => '2', 'price' => '400', 'classes' => 'gladiator-bow'],
                ['id' => '1076', 'src' => 'gladiators/bow_1_3.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '5', 'gold' => '3', 'price' => '400', 'classes' => 'gladiator-bow'],
                ['id' => '1077', 'src' => 'gladiators/bow_1_4.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '5', 'gold' => '3', 'price' => '400', 'classes' => 'gladiator-bow'],
                ['id' => '1078', 'src' => 'gladiators/bow_2_1.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '10', 'gold' => '4', 'price' => '800', 'classes' => 'gladiator-bow'],
                ['id' => '1079', 'src' => 'gladiators/bow_2_2.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '10', 'gold' => '4', 'price' => '800', 'classes' => 'gladiator-bow'],
                ['id' => '1080', 'src' => 'gladiators/bow_2_3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '10', 'gold' => '6', 'price' => '800', 'classes' => 'gladiator-bow'],
                ['id' => '1081', 'src' => 'gladiators/bow_2_4.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '10', 'gold' => '6', 'price' => '800', 'classes' => 'gladiator-bow'],
                ['id' => '1082', 'src' => 'gladiators/bow_3_1.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '20', 'gold' => '8', 'price' => '1200', 'classes' => 'gladiator-bow'],
                ['id' => '1083', 'src' => 'gladiators/bow_3_2.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '20', 'gold' => '8', 'price' => '1200', 'classes' => 'gladiator-bow'],
                ['id' => '1084', 'src' => 'gladiators/bow_3_3.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '20', 'gold' => '12', 'price' => '1200', 'classes' => 'gladiator-bow'],
                ['id' => '1085', 'src' => 'gladiators/bow_3_4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '20', 'gold' => '12', 'price' => '1200', 'classes' => 'gladiator-bow'],
                
                ['id' => '1090', 'src' => 'gladiators/hammer_0_1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-hammer'],
                ['id' => '1091', 'src' => 'gladiators/hammer_0_2.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-hammer'],
                ['id' => '1092', 'src' => 'gladiators/hammer_0_3.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-hammer'],
                ['id' => '1093', 'src' => 'gladiators/hammer_0_4.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-hammer'],
                ['id' => '1094', 'src' => 'gladiators/hammer_1_1.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '5', 'gold' => '2', 'price' => '400', 'classes' => 'gladiator-hammer'],
                ['id' => '1095', 'src' => 'gladiators/hammer_1_2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '5', 'gold' => '2', 'price' => '400', 'classes' => 'gladiator-hammer'],
                ['id' => '1096', 'src' => 'gladiators/hammer_1_3.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '5', 'gold' => '3', 'price' => '400', 'classes' => 'gladiator-hammer'],
                ['id' => '1097', 'src' => 'gladiators/hammer_1_4.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '5', 'gold' => '3', 'price' => '400', 'classes' => 'gladiator-hammer'],
                ['id' => '1098', 'src' => 'gladiators/hammer_2_1.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '10', 'gold' => '4', 'price' => '800', 'classes' => 'gladiator-hammer'],
                ['id' => '1099', 'src' => 'gladiators/hammer_2_2.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '10', 'gold' => '4', 'price' => '800', 'classes' => 'gladiator-hammer'],
                ['id' => '1100', 'src' => 'gladiators/hammer_2_3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '10', 'gold' => '6', 'price' => '800', 'classes' => 'gladiator-hammer'],
                ['id' => '1101', 'src' => 'gladiators/hammer_2_4.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '10', 'gold' => '6', 'price' => '800', 'classes' => 'gladiator-hammer'],
                ['id' => '1102', 'src' => 'gladiators/hammer_3_1.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '20', 'gold' => '8', 'price' => '1200', 'classes' => 'gladiator-hammer'],
                ['id' => '1103', 'src' => 'gladiators/hammer_3_2.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '20', 'gold' => '8', 'price' => '1200', 'classes' => 'gladiator-hammer'],
                ['id' => '1104', 'src' => 'gladiators/hammer_3_3.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '20', 'gold' => '12', 'price' => '1200', 'classes' => 'gladiator-hammer'],
                ['id' => '1105', 'src' => 'gladiators/hammer_3_4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '20', 'gold' => '12', 'price' => '1200', 'classes' => 'gladiator-hammer'],
                
                ['id' => '1110', 'src' => 'gladiators/spear_0_1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-spear'],
                ['id' => '1111', 'src' => 'gladiators/spear_0_2.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-spear'],
                ['id' => '1112', 'src' => 'gladiators/spear_0_3.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-spear'],
                ['id' => '1113', 'src' => 'gladiators/spear_0_4.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-spear'],
                ['id' => '1114', 'src' => 'gladiators/spear_1_1.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '5', 'gold' => '2', 'price' => '400', 'classes' => 'gladiator-spear'],
                ['id' => '1115', 'src' => 'gladiators/spear_1_2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '5', 'gold' => '2', 'price' => '400', 'classes' => 'gladiator-spear'],
                ['id' => '1116', 'src' => 'gladiators/spear_1_3.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '5', 'gold' => '3', 'price' => '400', 'classes' => 'gladiator-spear'],
                ['id' => '1117', 'src' => 'gladiators/spear_1_4.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '5', 'gold' => '3', 'price' => '400', 'classes' => 'gladiator-spear'],
                ['id' => '1118', 'src' => 'gladiators/spear_2_1.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '10', 'gold' => '4', 'price' => '800', 'classes' => 'gladiator-spear'],
                ['id' => '1119', 'src' => 'gladiators/spear_2_2.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '10', 'gold' => '4', 'price' => '800', 'classes' => 'gladiator-spear'],
                ['id' => '1120', 'src' => 'gladiators/spear_2_3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '10', 'gold' => '6', 'price' => '800', 'classes' => 'gladiator-spear'],
                ['id' => '1121', 'src' => 'gladiators/spear_2_4.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '10', 'gold' => '6', 'price' => '800', 'classes' => 'gladiator-spear'],
                ['id' => '1122', 'src' => 'gladiators/spear_3_1.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '20', 'gold' => '8', 'price' => '1200', 'classes' => 'gladiator-spear'],
                ['id' => '1123', 'src' => 'gladiators/spear_3_2.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '20', 'gold' => '8', 'price' => '1200', 'classes' => 'gladiator-spear'],
                ['id' => '1124', 'src' => 'gladiators/spear_3_3.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '20', 'gold' => '12', 'price' => '1200', 'classes' => 'gladiator-spear'],
                ['id' => '1125', 'src' => 'gladiators/spear_3_4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '20', 'gold' => '12', 'price' => '1200', 'classes' => 'gladiator-spear'],
                
                ['id' => '1130', 'src' => 'gladiators/sword_0_1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-sword'],
                ['id' => '1131', 'src' => 'gladiators/sword_0_2.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-sword'],
                ['id' => '1132', 'src' => 'gladiators/sword_0_3.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-sword'],
                ['id' => '1133', 'src' => 'gladiators/sword_0_4.png', 'offset' => '0', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gladiator-sword'],
                ['id' => '1134', 'src' => 'gladiators/sword_1_1.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '5', 'gold' => '2', 'price' => '400', 'classes' => 'gladiator-sword'],
                ['id' => '1135', 'src' => 'gladiators/sword_1_2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '3', 'xp' => '5', 'gold' => '2', 'price' => '400', 'classes' => 'gladiator-sword'],
                ['id' => '1136', 'src' => 'gladiators/sword_1_3.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '5', 'gold' => '3', 'price' => '400', 'classes' => 'gladiator-sword'],
                ['id' => '1137', 'src' => 'gladiators/sword_1_4.png', 'offset' => '1', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '2', 'xp' => '5', 'gold' => '3', 'price' => '400', 'classes' => 'gladiator-sword'],
                ['id' => '1138', 'src' => 'gladiators/sword_2_1.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '10', 'gold' => '4', 'price' => '800', 'classes' => 'gladiator-sword'],
                ['id' => '1139', 'src' => 'gladiators/sword_2_2.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '6', 'xp' => '10', 'gold' => '4', 'price' => '800', 'classes' => 'gladiator-sword'],
                ['id' => '1140', 'src' => 'gladiators/sword_2_3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '10', 'gold' => '6', 'price' => '800', 'classes' => 'gladiator-sword'],
                ['id' => '1141', 'src' => 'gladiators/sword_2_4.png', 'offset' => '2', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '4', 'xp' => '10', 'gold' => '6', 'price' => '800', 'classes' => 'gladiator-sword'],
                ['id' => '1142', 'src' => 'gladiators/sword_3_1.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '20', 'gold' => '8', 'price' => '1200', 'classes' => 'gladiator-sword'],
                ['id' => '1143', 'src' => 'gladiators/sword_3_2.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '12', 'xp' => '20', 'gold' => '8', 'price' => '1200', 'classes' => 'gladiator-sword'],
                ['id' => '1144', 'src' => 'gladiators/sword_3_3.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '20', 'gold' => '12', 'price' => '1200', 'classes' => 'gladiator-sword'],
                ['id' => '1145', 'src' => 'gladiators/sword_3_4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[57, 58, 59, 60, 61, 62]', 'hp' => '8', 'xp' => '20', 'gold' => '12', 'price' => '1200', 'classes' => 'gladiator-sword'],



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
