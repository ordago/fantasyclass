<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCharacterEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('equipment');

        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->json('character_id');
            $table->string('src', 100);
            $table->smallInteger('type');
            $table->integer('hp');
            $table->integer('xp');
            $table->integer('gold');
            $table->integer('price');
            $table->smallInteger('offset');
            $table->string('classes');
        });
        DB::table('equipment')->insert(
            [
                ['id' => '1', 'src' => 'boots-0_75d4eab23.png', 'offset' => '0', 'type' => '0', 'character_id' => '[1]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots'],
                ['id' => '2', 'src' => 'boots-1_cf6b23.png', 'offset' => '1', 'type' => '0', 'character_id' => '[1]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '150', 'classes' => 'boots'],
                ['id' => '3', 'src' => 'boots-2_cf69ab23.png', 'offset' => '2', 'type' => '0', 'character_id' => '[1]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '300', 'classes' => 'boots'],
                ['id' => '4', 'src' => 'boots-3_3f33afb.png', 'offset' => '3', 'type' => '0', 'character_id' => '[1]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '500', 'classes' => 'boots'],
                ['id' => '5', 'src' => 'armor-0_a6ab82e.png', 'offset' => '0', 'type' => '1', 'character_id' => '[1]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor'],
                ['id' => '6', 'src' => 'armor-1_97456.png', 'offset' => '1', 'type' => '1', 'character_id' => '[1]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '300', 'classes' => 'armor'],
                ['id' => '7', 'src' => 'armor-2_0762db6a6a.png', 'offset' => '2', 'type' => '1', 'character_id' => '[1]', 'hp' => '15', 'xp' => '5', 'gold' => '5', 'price' => '600', 'classes' => 'armor'],
                ['id' => '8', 'src' => 'armor-3_af890fb23.png', 'offset' => '3', 'type' => '1', 'character_id' => '[1]', 'hp' => '20', 'xp' => '10', 'gold' => '10', 'price' => '900', 'classes' => 'armor'],
                ['id' => '9', 'src' => 'guantlets-0_97s4d56.png', 'offset' => '0', 'type' => '2', 'character_id' => '[1]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gauntlet1'],
                ['id' => '10', 'src' => 'guantlets-1_12s78a.png', 'offset' => '1', 'type' => '2', 'character_id' => '[1]', 'hp' => '0', 'xp' => '0', 'gold' => '5', 'price' => '150', 'classes' => 'gauntlet1'],
                ['id' => '11', 'src' => 'guantlets-2_dc78a578.png', 'offset' => '2', 'type' => '2', 'character_id' => '[1]', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '300', 'classes' => 'gauntlet1'],
                ['id' => '12', 'src' => 'guantlets-3_785a78f.png', 'offset' => '3', 'type' => '2', 'character_id' => '[1]', 'hp' => '5', 'xp' => '5', 'gold' => '15', 'price' => '600', 'classes' => 'gauntlet1'],
                ['id' => '13', 'src' => 'helmet-0_97456.png', 'offset' => '0', 'type' => '3', 'character_id' => '[1]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet'],
                ['id' => '14', 'src' => 'helmet-1_a6ab82e.png', 'offset' => '1', 'type' => '3', 'character_id' => '[1]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'helmet'],
                ['id' => '15', 'src' => 'helmet-2_97s4d56.png', 'offset' => '2', 'type' => '3', 'character_id' => '[1]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '400', 'classes' => 'helmet'],
                ['id' => '16', 'src' => 'helmet-3_f6a0823.png', 'offset' => '3', 'type' => '3', 'character_id' => '[1]', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '500', 'classes' => 'helmet'],
                ['id' => '17', 'src' => 'shield-0_0762db6a6a.png', 'offset' => '0', 'type' => '4', 'character_id' => '[1]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'shield'],
                ['id' => '18', 'src' => 'shield-1_dc78a578.png', 'offset' => '1', 'type' => '4', 'character_id' => '[1]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '150', 'classes' => 'shield'],
                ['id' => '19', 'src' => 'shield-2_cf69ab23.png', 'offset' => '2', 'type' => '4', 'character_id' => '[1]', 'hp' => '15', 'xp' => '0', 'gold' => '0', 'price' => '300', 'classes' => 'shield'],
                ['id' => '20', 'src' => 'shield-3_a6ab82e.png', 'offset' => '3', 'type' => '4', 'character_id' => '[1]', 'hp' => '20', 'xp' => '10', 'gold' => '5', 'price' => '600', 'classes' => 'shield'],
                ['id' => '21', 'src' => 'sword-0_974536_char.png', 'offset' => '0', 'type' => '5', 'character_id' => '[1]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'sword'],
                ['id' => '22', 'src' => 'sword-1_3f33afb_char.png', 'offset' => '1', 'type' => '5', 'character_id' => '[1]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '300', 'classes' => 'sword'],
                ['id' => '23', 'src' => 'sword-2_dc78a578_char.png', 'offset' => '2', 'type' => '5', 'character_id' => '[1]', 'hp' => '0', 'xp' => '10', 'gold' => '10', 'price' => '600', 'classes' => 'sword'],
                ['id' => '24', 'src' => 'sword-3_a6abe82e_char.png', 'offset' => '3', 'type' => '5', 'character_id' => '[1]', 'hp' => '5', 'xp' => '15', 'gold' => '15', 'price' => '900', 'classes' => 'sword'],
                ['id' => '25', 'src' => 'boots-archer-0_943837.png', 'offset' => '0', 'type' => '0', 'character_id' => '[2]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots'],
                ['id' => '26', 'src' => 'boots-archer-1_0098721.png', 'offset' => '1', 'type' => '0', 'character_id' => '[2]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'boots'],
                ['id' => '27', 'src' => 'boots-archer-2_6673907.png', 'offset' => '2', 'type' => '0', 'character_id' => '[2]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '400', 'classes' => 'boots'],
                ['id' => '28', 'src' => 'boots-archer-3_133928.png', 'offset' => '3', 'type' => '0', 'character_id' => '[2]', 'hp' => '10', 'xp' => '20', 'gold' => '10', 'price' => '600', 'classes' => 'boots'],
                ['id' => '29', 'src' => 'armor-archer-0_921afe2.png', 'offset' => '0', 'type' => '1', 'character_id' => '[2]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor'],
                ['id' => '30', 'src' => 'armor-archer-1_aaf34e2d.png', 'offset' => '1', 'type' => '1', 'character_id' => '[2]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'armor'],
                ['id' => '31', 'src' => 'armor-archer-2_feb4c503.png', 'offset' => '2', 'type' => '1', 'character_id' => '[2]', 'hp' => '10', 'xp' => '15', 'gold' => '5', 'price' => '400', 'classes' => 'armor'],
                ['id' => '32', 'src' => 'armor-archer-3_9a8ddd64.png', 'offset' => '3', 'type' => '1', 'character_id' => '[2]', 'hp' => '10', 'xp' => '20', 'gold' => '15', 'price' => '600', 'classes' => 'armor'],
                ['id' => '33', 'src' => 'helmet_archer_0-5ec62a.png', 'offset' => '0', 'type' => '3', 'character_id' => '[2]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet'],
                ['id' => '34', 'src' => 'helmet_archer_1-eff623a.png', 'offset' => '1', 'type' => '3', 'character_id' => '[2]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'helmet'],
                ['id' => '35', 'src' => 'helmet_archer_2-555afc3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[2]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'helmet'],
                ['id' => '36', 'src' => 'helmet_archer_3-fa98340abc.png', 'offset' => '3', 'type' => '3', 'character_id' => '[2]', 'hp' => '10', 'xp' => '20', 'gold' => '10', 'price' => '1000', 'classes' => 'helmet'],
                ['id' => '37', 'src' => 'bow-0_ffb467.png', 'offset' => '0', 'type' => '5', 'character_id' => '[2]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'bow'],
                ['id' => '38', 'src' => 'bow-1_05fc4dd3.png', 'offset' => '1', 'type' => '5', 'character_id' => '[2]', 'hp' => '0', 'xp' => '15', 'gold' => '5', 'price' => '700', 'classes' => 'bow'],
                ['id' => '39', 'src' => 'bow-2_fcafb.png', 'offset' => '2', 'type' => '5', 'character_id' => '[2]', 'hp' => '5', 'xp' => '15', 'gold' => '10', 'price' => '1400', 'classes' => 'bow'],
                ['id' => '40', 'src' => 'bow-3_34abc56.png', 'offset' => '3', 'type' => '5', 'character_id' => '[2]', 'hp' => '10', 'xp' => '20', 'gold' => '15', 'price' => '2000', 'classes' => 'bow'],
                ['id' => '41', 'src' => 'archer_gauntlets.png', 'offset' => '0', 'type' => '2', 'character_id' => '[2]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gauntlet2'],
                ['id' => '42', 'src' => 'boots-mage-0_92084afc.png', 'offset' => '0', 'type' => '0', 'character_id' => '[3]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots'],
                ['id' => '43', 'src' => 'boots-mage-1_a2f4c3.png', 'offset' => '1', 'type' => '0', 'character_id' => '[3]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'boots'],
                ['id' => '44', 'src' => 'boots-mage-2_ffcac4.png', 'offset' => '2', 'type' => '0', 'character_id' => '[3]', 'hp' => '5', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'boots'],
                ['id' => '45', 'src' => 'boots-mage-4_0765ba2.png', 'offset' => '3', 'type' => '0', 'character_id' => '[3]', 'hp' => '10', 'xp' => '10', 'gold' => '20', 'price' => '600', 'classes' => 'boots'],
                ['id' => '46', 'src' => 'armor-mage-0_88623.png', 'offset' => '0', 'type' => '1', 'character_id' => '[3]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor'],
                ['id' => '47', 'src' => 'armor-mage-1_76ab3c3.png', 'offset' => '1', 'type' => '1', 'character_id' => '[3]', 'hp' => '0', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'armor'],
                ['id' => '48', 'src' => 'armor-mage-2_998abe3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[3]', 'hp' => '5', 'xp' => '5', 'gold' => '15', 'price' => '400', 'classes' => 'armor'],
                ['id' => '49', 'src' => 'armor-mage-3_ffc43.png', 'offset' => '3', 'type' => '1', 'character_id' => '[3]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '600', 'classes' => 'armor'],
                ['id' => '50', 'src' => 'mage_guantlets.png', 'offset' => '0', 'type' => '2', 'character_id' => '[3]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gauntlet2'],
                ['id' => '51', 'src' => 'helmet-mage-0_23453465.png', 'offset' => '0', 'type' => '3', 'character_id' => '[3]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet helmet-mage'],
                ['id' => '52', 'src' => 'helmet-mage-1_abc7392.png', 'offset' => '1', 'type' => '3', 'character_id' => '[3]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'helmet helmet-mage'],
                ['id' => '53', 'src' => 'helmet-mage-2_971bb2.png', 'offset' => '2', 'type' => '3', 'character_id' => '[3]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'helmet helmet-mage'],
                ['id' => '54', 'src' => 'helmet-mage-3_ab673.png', 'offset' => '3', 'type' => '3', 'character_id' => '[3]', 'hp' => '10', 'xp' => '10', 'gold' => '20', 'price' => '1000', 'classes' => 'helmet helmet-mage'],
                ['id' => '55', 'src' => 'staff-0_9827.png', 'offset' => '0', 'type' => '5', 'character_id' => '[3]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'staff'],
                ['id' => '56', 'src' => 'staff-1_abcfff.png', 'offset' => '1', 'type' => '5', 'character_id' => '[3]', 'hp' => '5', 'xp' => '0', 'gold' => '15', 'price' => '700', 'classes' => 'staff'],
                ['id' => '57', 'src' => 'staff-2_ffa67dca.png', 'offset' => '2', 'type' => '5', 'character_id' => '[3]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1400', 'classes' => 'staff'],
                ['id' => '58', 'src' => 'staff-3_43d2cfe.png', 'offset' => '3', 'type' => '5', 'character_id' => '[3]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '2000', 'classes' => 'staff'],
                ['id' => '59', 'src' => 'robots/robot1_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[4]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'bootsRobot1'],
                ['id' => '60', 'src' => 'robots/robot1_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[4]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'bootsRobot1'],
                ['id' => '61', 'src' => 'robots/robot1_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[4]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '400', 'classes' => 'bootsRobot1'],
                ['id' => '62', 'src' => 'robots/robot1_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[4]', 'hp' => '10', 'xp' => '20', 'gold' => '10', 'price' => '600', 'classes' => 'bootsRobot1'],
                ['id' => '63', 'src' => 'robots/robot1_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[4]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armorRobot1'],
                ['id' => '64', 'src' => 'robots/robot1_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[4]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'armorRobot1'],
                ['id' => '65', 'src' => 'robots/robot1_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[4]', 'hp' => '10', 'xp' => '15', 'gold' => '5', 'price' => '400', 'classes' => 'armorRobot1'],
                ['id' => '66', 'src' => 'robots/robot1_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[4]', 'hp' => '10', 'xp' => '20', 'gold' => '15', 'price' => '800', 'classes' => 'armorRobot1'],
                ['id' => '67', 'src' => 'robots/robot1_bowtie.png', 'offset' => '0', 'type' => '2', 'character_id' => '[4]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'bowTieRobot1'],
                ['id' => '68', 'src' => 'robots/robot1_eq1_bowtie.png', 'offset' => '1', 'type' => '2', 'character_id' => '[4]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'bowTieRobot1'],
                ['id' => '69', 'src' => 'robots/robot1_eq2_bowtie.png', 'offset' => '2', 'type' => '2', 'character_id' => '[4]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'bowTieRobot1'],
                ['id' => '70', 'src' => 'robots/robot1_eq3_bowtie.png', 'offset' => '3', 'type' => '2', 'character_id' => '[4]', 'hp' => '10', 'xp' => '20', 'gold' => '10', 'price' => '600', 'classes' => 'bowTieRobot1'],
                ['id' => '71', 'src' => 'robots/robot1_head.png', 'offset' => '0', 'type' => '3', 'character_id' => '[4]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet helmetRobot1'],
                ['id' => '72', 'src' => 'robots/robot1_eq1_head.png', 'offset' => '1', 'type' => '3', 'character_id' => '[4]', 'hp' => '0', 'xp' => '15', 'gold' => '5', 'price' => '700', 'classes' => 'helmet helmetRobot1'],
                ['id' => '73', 'src' => 'robots/robot1_eq2_head.png', 'offset' => '2', 'type' => '3', 'character_id' => '[4]', 'hp' => '5', 'xp' => '15', 'gold' => '10', 'price' => '1000', 'classes' => 'helmet helmetRobot1'],
                ['id' => '74', 'src' => 'robots/robot1_eq3_head.png', 'offset' => '3', 'type' => '3', 'character_id' => '[4]', 'hp' => '10', 'xp' => '20', 'gold' => '15', 'price' => '1800', 'classes' => 'helmet helmetRobot1'],
                ['id' => '75', 'src' => 'robots/robot1_gauntlet.png', 'offset' => '0', 'type' => '4', 'character_id' => '[4]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gauntletRobot1'],
                ['id' => '76', 'src' => 'robots/robot2_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[5]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'bootsRobot2'],
                ['id' => '77', 'src' => 'robots/robot2_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[5]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'bootsRobot2'],
                ['id' => '78', 'src' => 'robots/robot2_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[5]', 'hp' => '15', 'xp' => '0', 'gold' => '0', 'price' => '300', 'classes' => 'bootsRobot2'],
                ['id' => '79', 'src' => 'robots/robot2_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[5]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '500', 'classes' => 'bootsRobot2'],
                ['id' => '80', 'src' => 'robots/robot2_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[5]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armorRobot2'],
                ['id' => '81', 'src' => 'robots/robot2_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[5]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '400', 'classes' => 'armorRobot2'],
                ['id' => '82', 'src' => 'robots/robot2_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[5]', 'hp' => '15', 'xp' => '5', 'gold' => '10', 'price' => '800', 'classes' => 'armorRobot2'],
                ['id' => '83', 'src' => 'robots/robot2_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[5]', 'hp' => '20', 'xp' => '10', 'gold' => '10', 'price' => '900', 'classes' => 'armorRobot2'],
                ['id' => '84', 'src' => 'robots/robot2_eyes.png', 'offset' => '0', 'type' => '2', 'character_id' => '[5]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'bowTieRobot2'],
                ['id' => '85', 'src' => 'robots/robot2_eq1_eyes.png', 'offset' => '1', 'type' => '2', 'character_id' => '[5]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'bowTieRobot2'],
                ['id' => '86', 'src' => 'robots/robot2_eq2_eyes.png', 'offset' => '2', 'type' => '2', 'character_id' => '[5]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '400', 'classes' => 'bowTieRobot2'],
                ['id' => '87', 'src' => 'robots/robot2_eq3_eyes.png', 'offset' => '3', 'type' => '2', 'character_id' => '[5]', 'hp' => '15', 'xp' => '15', 'gold' => '15', 'price' => '900', 'classes' => 'bowTieRobot2'],
                ['id' => '88', 'src' => 'robots/robot2_head.png', 'offset' => '0', 'type' => '3', 'character_id' => '[5]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet helmetRobot2'],
                ['id' => '89', 'src' => 'robots/robot2_eq1_head.png', 'offset' => '1', 'type' => '3', 'character_id' => '[5]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'helmet helmetRobot2'],
                ['id' => '90', 'src' => 'robots/robot2_eq2_head.png', 'offset' => '2', 'type' => '3', 'character_id' => '[5]', 'hp' => '5', 'xp' => '5', 'gold' => '5', 'price' => '300', 'classes' => 'helmet helmetRobot2'],
                ['id' => '91', 'src' => 'robots/robot2_eq3_head.png', 'offset' => '3', 'type' => '3', 'character_id' => '[5]', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '900', 'classes' => 'helmet helmetRobot2'],
                ['id' => '92', 'src' => 'robots/robot2_arms.png', 'offset' => '0', 'type' => '4', 'character_id' => '[5]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gauntletRobot2 armorRobot2'],
                ['id' => '93', 'src' => 'robots/robot2_eq1_arms.png', 'offset' => '1', 'type' => '4', 'character_id' => '[5]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '300', 'classes' => 'gauntletRobot2 armorRobot2'],
                ['id' => '94', 'src' => 'robots/robot2_eq2_arms.png', 'offset' => '2', 'type' => '4', 'character_id' => '[5]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'gauntletRobot2 armorRobot2'],
                ['id' => '95', 'src' => 'robots/robot2_eq3_arms.png', 'offset' => '3', 'type' => '4', 'character_id' => '[5]', 'hp' => '10', 'xp' => '5', 'gold' => '15', 'price' => '600', 'classes' => 'gauntletRobot2 armorRobot2'],
                ['id' => '96', 'src' => 'robots/robot3_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[6]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'bootsRobot3'],
                ['id' => '97', 'src' => 'robots/robot3_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[6]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'bootsRobot3'],
                ['id' => '98', 'src' => 'robots/robot3_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[6]', 'hp' => '5', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'bootsRobot3'],
                ['id' => '99', 'src' => 'robots/robot3_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[6]', 'hp' => '10', 'xp' => '10', 'gold' => '20', 'price' => '600', 'classes' => 'bootsRobot3'],
                ['id' => '100', 'src' => 'robots/robot3_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[6]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armorRobot3'],
                ['id' => '101', 'src' => 'robots/robot3_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[6]', 'hp' => '0', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'armorRobot3'],
                ['id' => '102', 'src' => 'robots/robot3_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[6]', 'hp' => '5', 'xp' => '5', 'gold' => '15', 'price' => '400', 'classes' => 'armorRobot3'],
                ['id' => '103', 'src' => 'robots/robot3_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[6]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '800', 'classes' => 'armorRobot3'],
                ['id' => '108', 'src' => 'robots/robot3_head.png', 'offset' => '0', 'type' => '3', 'character_id' => '[6]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet helmetRobot3'],
                ['id' => '109', 'src' => 'robots/robot3_eq1_head.png', 'offset' => '1', 'type' => '3', 'character_id' => '[6]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'helmet helmetRobot3'],
                ['id' => '110', 'src' => 'robots/robot3_eq2_head.png', 'offset' => '2', 'type' => '3', 'character_id' => '[6]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'helmet helmetRobot3'],
                ['id' => '111', 'src' => 'robots/robot3_eq3_head.png', 'offset' => '3', 'type' => '3', 'character_id' => '[6]', 'hp' => '10', 'xp' => '10', 'gold' => '20', 'price' => '600', 'classes' => 'helmet helmetRobot3'],
                ['id' => '112', 'src' => 'robots/robot3_arms.png', 'offset' => '0', 'type' => '4', 'character_id' => '[6]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'gauntletRobot3 armorRobot3'],
                ['id' => '113', 'src' => 'robots/robot3_eq1_arms.png', 'offset' => '1', 'type' => '4', 'character_id' => '[6]', 'hp' => '5', 'xp' => '0', 'gold' => '15', 'price' => '700', 'classes' => 'gauntletRobot3 armorRobot3'],
                ['id' => '114', 'src' => 'robots/robot3_eq2_arms.png', 'offset' => '2', 'type' => '4', 'character_id' => '[6]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1000', 'classes' => 'gauntletRobot3 armorRobot3'],
                ['id' => '115', 'src' => 'robots/robot3_eq3_arms.png', 'offset' => '3', 'type' => '4', 'character_id' => '[6]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '1800', 'classes' => 'gauntletRobot3 armorRobot3'],
                ['id' => '140', 'src' => 'superheros/sh0_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[7]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute legs-sh1'],
                ['id' => '141', 'src' => 'superheros/sh0_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[7]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'is-absolute legs-sh1'],
                ['id' => '142', 'src' => 'superheros/sh0_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[7]', 'hp' => '5', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'is-absolute legs-sh1'],
                ['id' => '143', 'src' => 'superheros/sh0_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[7]', 'hp' => '10', 'xp' => '10', 'gold' => '20', 'price' => '600', 'classes' => 'is-absolute legs-sh1'],
                ['id' => '144', 'src' => 'superheros/sh0_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[7]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute body-sh1 lastPart'],
                ['id' => '145', 'src' => 'superheros/sh0_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[7]', 'hp' => '0', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'is-absolute body-sh1 lastPart'],
                ['id' => '146', 'src' => 'superheros/sh0_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[7]', 'hp' => '5', 'xp' => '5', 'gold' => '15', 'price' => '400', 'classes' => 'is-absolute body-sh1 lastPart'],
                ['id' => '147', 'src' => 'superheros/sh0_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[7]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '800', 'classes' => 'is-absolute body-sh1 lastPart'],
                ['id' => '148', 'src' => 'superheros/sh0_head.png', 'offset' => '0', 'type' => '3', 'character_id' => '[7]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute head-sh1'],
                ['id' => '149', 'src' => 'superheros/sh0_eq1_head.png', 'offset' => '1', 'type' => '3', 'character_id' => '[7]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'is-absolute head-sh1'],
                ['id' => '150', 'src' => 'superheros/sh0_eq2_head.png', 'offset' => '2', 'type' => '3', 'character_id' => '[7]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute head-sh1'],
                ['id' => '151', 'src' => 'superheros/sh0_eq3_head.png', 'offset' => '3', 'type' => '3', 'character_id' => '[7]', 'hp' => '10', 'xp' => '10', 'gold' => '20', 'price' => '600', 'classes' => 'is-absolute head-sh1'],
                ['id' => '152', 'src' => 'superheros/sh0_arms.png', 'offset' => '0', 'type' => '4', 'character_id' => '[7]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute arms-sh1 backPart'],
                ['id' => '153', 'src' => 'superheros/sh0_eq1_arms.png', 'offset' => '1', 'type' => '4', 'character_id' => '[7]', 'hp' => '5', 'xp' => '0', 'gold' => '15', 'price' => '700', 'classes' => 'is-absolute arms-sh1 backPart'],
                ['id' => '154', 'src' => 'superheros/sh0_eq2_arms.png', 'offset' => '2', 'type' => '4', 'character_id' => '[7]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1000', 'classes' => 'is-absolute arms-sh1 backPart'],
                ['id' => '155', 'src' => 'superheros/sh0_eq3_arms.png', 'offset' => '3', 'type' => '4', 'character_id' => '[7]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '1800', 'classes' => 'is-absolute arms-sh1 backPart'],
                ['id' => '160', 'src' => 'superheros/sh1_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[8]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute legs-sh2'],
                ['id' => '161', 'src' => 'superheros/sh1_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[8]', 'hp' => '0', 'xp' => '0', 'gold' => '5', 'price' => '200', 'classes' => 'is-absolute legs-sh2'],
                ['id' => '162', 'src' => 'superheros/sh1_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[8]', 'hp' => '10', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute legs-sh2'],
                ['id' => '163', 'src' => 'superheros/sh1_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[8]', 'hp' => '20', 'xp' => '10', 'gold' => '10', 'price' => '600', 'classes' => 'is-absolute legs-sh2'],
                ['id' => '164', 'src' => 'superheros/sh1_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[8]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute body-sh2 lastPart'],
                ['id' => '165', 'src' => 'superheros/sh1_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[8]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '400', 'classes' => 'is-absolute body-sh2 lastPart'],
                ['id' => '166', 'src' => 'superheros/sh1_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[8]', 'hp' => '15', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute body-sh2 lastPart'],
                ['id' => '167', 'src' => 'superheros/sh1_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[8]', 'hp' => '20', 'xp' => '15', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute body-sh2 lastPart'],
                ['id' => '168', 'src' => 'superheros/sh1_head.png', 'offset' => '0', 'type' => '3', 'character_id' => '[8]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute head-sh2'],
                ['id' => '169', 'src' => 'superheros/sh1_eq1_head.png', 'offset' => '1', 'type' => '3', 'character_id' => '[8]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'is-absolute head-sh2'],
                ['id' => '170', 'src' => 'superheros/sh1_eq2_head.png', 'offset' => '2', 'type' => '3', 'character_id' => '[8]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute head-sh2'],
                ['id' => '171', 'src' => 'superheros/sh1_eq3_head.png', 'offset' => '3', 'type' => '3', 'character_id' => '[8]', 'hp' => '20', 'xp' => '10', 'gold' => '10', 'price' => '600', 'classes' => 'is-absolute head-sh2'],
                ['id' => '172', 'src' => 'superheros/sh1_amulet.png', 'offset' => '0', 'type' => '4', 'character_id' => '[8]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute arms-sh2'],
                ['id' => '173', 'src' => 'superheros/sh1_eq1_amulet.png', 'offset' => '1', 'type' => '4', 'character_id' => '[8]', 'hp' => '15', 'xp' => '0', 'gold' => '5', 'price' => '700', 'classes' => 'is-absolute arms-sh2'],
                ['id' => '174', 'src' => 'superheros/sh1_eq2_amulet.png', 'offset' => '2', 'type' => '4', 'character_id' => '[8]', 'hp' => '15', 'xp' => '10', 'gold' => '5', 'price' => '1000', 'classes' => 'is-absolute arms-sh2'],
                ['id' => '175', 'src' => 'superheros/sh1_eq3_amulet.png', 'offset' => '3', 'type' => '4', 'character_id' => '[8]', 'hp' => '20', 'xp' => '15', 'gold' => '10', 'price' => '1800', 'classes' => 'is-absolute arms-sh2'],
                ['id' => '180', 'src' => 'superheros/sh2_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[9]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute legs-sh3'],
                ['id' => '181', 'src' => 'superheros/sh2_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[9]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'is-absolute legs-sh3'],
                ['id' => '182', 'src' => 'superheros/sh2_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[9]', 'hp' => '5', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'is-absolute legs-sh3'],
                ['id' => '183', 'src' => 'superheros/sh2_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[9]', 'hp' => '10', 'xp' => '20', 'gold' => '10', 'price' => '600', 'classes' => 'is-absolute legs-sh3'],
                ['id' => '184', 'src' => 'superheros/sh2_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[9]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute body-sh3 lastPart'],
                ['id' => '185', 'src' => 'superheros/sh2_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[9]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'is-absolute body-sh3 lastPart'],
                ['id' => '186', 'src' => 'superheros/sh2_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[9]', 'hp' => '5', 'xp' => '15', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute body-sh3 lastPart'],
                ['id' => '187', 'src' => 'superheros/sh2_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[9]', 'hp' => '15', 'xp' => '10', 'gold' => '20', 'price' => '800', 'classes' => 'is-absolute body-sh3 lastPart'],
                ['id' => '188', 'src' => 'superheros/sh2_head.png', 'offset' => '0', 'type' => '3', 'character_id' => '[9]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute head-sh3'],
                ['id' => '189', 'src' => 'superheros/sh2_eq1_head.png', 'offset' => '1', 'type' => '3', 'character_id' => '[9]', 'hp' => '0', 'xp' => '0', 'gold' => '5', 'price' => '200', 'classes' => 'is-absolute head-sh3'],
                ['id' => '190', 'src' => 'superheros/sh2_eq2_head.png', 'offset' => '2', 'type' => '3', 'character_id' => '[9]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute head-sh3'],
                ['id' => '191', 'src' => 'superheros/sh2_eq3_head.png', 'offset' => '3', 'type' => '3', 'character_id' => '[9]', 'hp' => '10', 'xp' => '20', 'gold' => '10', 'price' => '600', 'classes' => 'is-absolute head-sh3'],
                ['id' => '192', 'src' => 'superheros/sh2_arms.png', 'offset' => '0', 'type' => '4', 'character_id' => '[9]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute arms-sh3 backPart'],
                ['id' => '193', 'src' => 'superheros/sh2_eq1_arms.png', 'offset' => '1', 'type' => '4', 'character_id' => '[9]', 'hp' => '5', 'xp' => '15', 'gold' => '0', 'price' => '700', 'classes' => 'is-absolute arms-sh3 backPart'],
                ['id' => '194', 'src' => 'superheros/sh2_eq2_arms.png', 'offset' => '2', 'type' => '4', 'character_id' => '[9]', 'hp' => '5', 'xp' => '15', 'gold' => '10', 'price' => '1000', 'classes' => 'is-absolute arms-sh3 backPart'],
                ['id' => '195', 'src' => 'superheros/sh2_eq3_arms.png', 'offset' => '3', 'type' => '4', 'character_id' => '[9]', 'hp' => '10', 'xp' => '20', 'gold' => '15', 'price' => '1800', 'classes' => 'is-absolute arms-sh3 backPart'],

                ['id' => '200', 'src' => 'pirateanimals/seal_tail.png', 'offset' => '0', 'type' => '0', 'character_id' => '[10]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute tail-1'],
                ['id' => '201', 'src' => 'pirateanimals/seal_eq1_tail.png', 'offset' => '1', 'type' => '0', 'character_id' => '[10]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute tail-1'],
                ['id' => '202', 'src' => 'pirateanimals/seal_eq2_tail.png', 'offset' => '2', 'type' => '0', 'character_id' => '[10]', 'hp' => '10', 'xp' => '5', 'gold' => '15', 'price' => '1000', 'classes' => 'is-absolute tail-1'],
                ['id' => '203', 'src' => 'pirateanimals/seal_eq3_tail.png', 'offset' => '3', 'type' => '0', 'character_id' => '[10]', 'hp' => '20', 'xp' => '15', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute tail-1'],
                ['id' => '204', 'src' => 'pirateanimals/seal_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[10]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute body-1'],
                ['id' => '205', 'src' => 'pirateanimals/seal_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[10]', 'hp' => '5', 'xp' => '0', 'gold' => '15', 'price' => '700', 'classes' => 'is-absolute body-1'],
                ['id' => '206', 'src' => 'pirateanimals/seal_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[10]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '800', 'classes' => 'is-absolute body-1'],
                ['id' => '207', 'src' => 'pirateanimals/seal_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[10]', 'hp' => '20', 'xp' => '15', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute body-1'],
                ['id' => '208', 'src' => 'pirateanimals/seal_head.png', 'offset' => '0', 'type' => '2', 'character_id' => '[10]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute head-1 moveHeadUD'],
                ['id' => '209', 'src' => 'pirateanimals/seal_eq1_head.png', 'offset' => '1', 'type' => '2', 'character_id' => '[10]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute head-1 moveHeadUD'],
                ['id' => '210', 'src' => 'pirateanimals/seal_eq2_head.png', 'offset' => '2', 'type' => '2', 'character_id' => '[10]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute head-1 moveHeadUD'],
                ['id' => '211', 'src' => 'pirateanimals/seal_eq3_head.png', 'offset' => '3', 'type' => '2', 'character_id' => '[10]', 'hp' => '40', 'xp' => '20', 'gold' => '20', 'price' => '1600', 'classes' => 'is-absolute head-1 moveHeadUD'],
                ['id' => '220', 'src' => 'pirateanimals/donkey_tail.png', 'offset' => '0', 'type' => '0', 'character_id' => '[11]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute tail-2'],
                ['id' => '221', 'src' => 'pirateanimals/donkey_eq1_tail.png', 'offset' => '1', 'type' => '0', 'character_id' => '[11]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute tail-2'],
                ['id' => '222', 'src' => 'pirateanimals/donkey_eq2_tail.png', 'offset' => '2', 'type' => '0', 'character_id' => '[11]', 'hp' => '15', 'xp' => '5', 'gold' => '10', 'price' => '1000', 'classes' => 'is-absolute tail-2'],
                ['id' => '223', 'src' => 'pirateanimals/donkey_eq3_tail.png', 'offset' => '3', 'type' => '0', 'character_id' => '[11]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '1200', 'classes' => 'is-absolute tail-2'],
                ['id' => '224', 'src' => 'pirateanimals/donkey_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[11]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute body-2'],
                ['id' => '225', 'src' => 'pirateanimals/donkey_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[11]', 'hp' => '15', 'xp' => '0', 'gold' => '5', 'price' => '700', 'classes' => 'is-absolute body-2'],
                ['id' => '226', 'src' => 'pirateanimals/donkey_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[11]', 'hp' => '15', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'is-absolute body-2'],
                ['id' => '227', 'src' => 'pirateanimals/donkey_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[11]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '1200', 'classes' => 'is-absolute body-2'],
                ['id' => '228', 'src' => 'pirateanimals/donkey_head.png', 'offset' => '0', 'type' => '2', 'character_id' => '[11]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute head-2 moveHeadUD'],
                ['id' => '229', 'src' => 'pirateanimals/donkey_eq1_head.png', 'offset' => '1', 'type' => '2', 'character_id' => '[11]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '400', 'classes' => 'is-absolute head-2 moveHeadUD'],
                ['id' => '230', 'src' => 'pirateanimals/donkey_eq2_head.png', 'offset' => '2', 'type' => '2', 'character_id' => '[11]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute head-2 moveHeadUD'],
                ['id' => '231', 'src' => 'pirateanimals/donkey_eq3_head.png', 'offset' => '3', 'type' => '2', 'character_id' => '[11]', 'hp' => '20', 'xp' => '20', 'gold' => '40', 'price' => '1600', 'classes' => 'is-absolute head-2 moveHeadUD'],
                ['id' => '240', 'src' => 'pirateanimals/castor_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[12]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute legs-3'],
                ['id' => '241', 'src' => 'pirateanimals/castor_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[12]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute legs-3'],
                ['id' => '242', 'src' => 'pirateanimals/castor_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[12]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1000', 'classes' => 'is-absolute legs-3'],
                ['id' => '243', 'src' => 'pirateanimals/castor_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[12]', 'hp' => '15', 'xp' => '20', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute legs-3'],
                ['id' => '244', 'src' => 'pirateanimals/castor_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[12]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute body-3'],
                ['id' => '245', 'src' => 'pirateanimals/castor_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[12]', 'hp' => '0', 'xp' => '5', 'gold' => '15', 'price' => '700', 'classes' => 'is-absolute body-3'],
                ['id' => '246', 'src' => 'pirateanimals/castor_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[12]', 'hp' => '10', 'xp' => '5', 'gold' => '15', 'price' => '800', 'classes' => 'is-absolute body-3'],
                ['id' => '247', 'src' => 'pirateanimals/castor_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[12]', 'hp' => '15', 'xp' => '20', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute body-3'],
                ['id' => '248', 'src' => 'pirateanimals/castor_head.png', 'offset' => '0', 'type' => '2', 'character_id' => '[12]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute head-3 moveHeadUD'],
                ['id' => '249', 'src' => 'pirateanimals/castor_eq1_head.png', 'offset' => '1', 'type' => '2', 'character_id' => '[12]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute head-3 moveHeadUD'],
                ['id' => '250', 'src' => 'pirateanimals/castor_eq2_head.png', 'offset' => '2', 'type' => '2', 'character_id' => '[12]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute head-3 moveHeadUD'],
                ['id' => '251', 'src' => 'pirateanimals/castor_eq3_head.png', 'offset' => '3', 'type' => '2', 'character_id' => '[12]', 'hp' => '20', 'xp' => '40', 'gold' => '20', 'price' => '1600', 'classes' => 'is-absolute head-3 moveHeadUD'],
                ['id' => '260', 'src' => 'pirateanimals/tiger_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[13]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute legs-4'],
                ['id' => '261', 'src' => 'pirateanimals/tiger_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[13]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute legs-4'],
                ['id' => '262', 'src' => 'pirateanimals/tiger_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[13]', 'hp' => '10', 'xp' => '5', 'gold' => '15', 'price' => '1000', 'classes' => 'is-absolute legs-4'],
                ['id' => '263', 'src' => 'pirateanimals/tiger_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[13]', 'hp' => '20', 'xp' => '15', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute legs-4'],
                ['id' => '264', 'src' => 'pirateanimals/tiger_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[13]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute body-4'],
                ['id' => '265', 'src' => 'pirateanimals/tiger_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[13]', 'hp' => '5', 'xp' => '0', 'gold' => '15', 'price' => '700', 'classes' => 'is-absolute body-4'],
                ['id' => '266', 'src' => 'pirateanimals/tiger_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[13]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '800', 'classes' => 'is-absolute body-4'],
                ['id' => '267', 'src' => 'pirateanimals/tiger_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[13]', 'hp' => '20', 'xp' => '15', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute body-4'],
                ['id' => '268', 'src' => 'pirateanimals/tiger_head.png', 'offset' => '0', 'type' => '2', 'character_id' => '[13]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute head-4 moveHeadUD'],
                ['id' => '269', 'src' => 'pirateanimals/tiger_eq1_head.png', 'offset' => '1', 'type' => '2', 'character_id' => '[13]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute head-4 moveHeadUD'],
                ['id' => '270', 'src' => 'pirateanimals/tiger_eq2_head.png', 'offset' => '2', 'type' => '2', 'character_id' => '[13]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute head-4 moveHeadUD'],
                ['id' => '271', 'src' => 'pirateanimals/tiger_eq3_head.png', 'offset' => '3', 'type' => '2', 'character_id' => '[13]', 'hp' => '40', 'xp' => '20', 'gold' => '20', 'price' => '1600', 'classes' => 'is-absolute head-4 moveHeadUD'],
                ['id' => '280', 'src' => 'pirateanimals/croco_legs.png', 'offset' => '0', 'type' => '0', 'character_id' => '[14]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute legs-5'],
                ['id' => '281', 'src' => 'pirateanimals/croco_eq1_legs.png', 'offset' => '1', 'type' => '0', 'character_id' => '[14]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute legs-5'],
                ['id' => '282', 'src' => 'pirateanimals/croco_eq2_legs.png', 'offset' => '2', 'type' => '0', 'character_id' => '[14]', 'hp' => '15', 'xp' => '5', 'gold' => '10', 'price' => '1000', 'classes' => 'is-absolute legs-5'],
                ['id' => '283', 'src' => 'pirateanimals/croco_eq3_legs.png', 'offset' => '3', 'type' => '0', 'character_id' => '[14]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '1200', 'classes' => 'is-absolute legs-5'],
                ['id' => '284', 'src' => 'pirateanimals/croco_body.png', 'offset' => '0', 'type' => '1', 'character_id' => '[14]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute body-5'],
                ['id' => '285', 'src' => 'pirateanimals/croco_eq1_body.png', 'offset' => '1', 'type' => '1', 'character_id' => '[14]', 'hp' => '15', 'xp' => '0', 'gold' => '5', 'price' => '700', 'classes' => 'is-absolute body-5'],
                ['id' => '286', 'src' => 'pirateanimals/croco_eq2_body.png', 'offset' => '2', 'type' => '1', 'character_id' => '[14]', 'hp' => '15', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'is-absolute body-5'],
                ['id' => '287', 'src' => 'pirateanimals/croco_eq3_body.png', 'offset' => '3', 'type' => '1', 'character_id' => '[14]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '1200', 'classes' => 'is-absolute body-5'],
                ['id' => '288', 'src' => 'pirateanimals/croco_head.png', 'offset' => '0', 'type' => '2', 'character_id' => '[14]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute head-5 moveHeadUD'],
                ['id' => '289', 'src' => 'pirateanimals/croco_eq1_head.png', 'offset' => '1', 'type' => '2', 'character_id' => '[14]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '400', 'classes' => 'is-absolute head-5 moveHeadUD'],
                ['id' => '290', 'src' => 'pirateanimals/croco_eq2_head.png', 'offset' => '2', 'type' => '2', 'character_id' => '[14]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute head-5 moveHeadUD'],
                ['id' => '291', 'src' => 'pirateanimals/croco_eq3_head.png', 'offset' => '3', 'type' => '2', 'character_id' => '[14]', 'hp' => '20', 'xp' => '20', 'gold' => '40', 'price' => '1600', 'classes' => 'is-absolute head-5 moveHeadUD'],
                ['id' => '300', 'src' => 'skeleton_head.png', 'offset' => '0', 'type' => '1', 'character_id' => '[15]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet'],
                ['id' => '301', 'src' => 'skeleton_body.png', 'offset' => '0', 'type' => '2', 'character_id' => '[15]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor'],
                ['id' => '302', 'src' => 'skeleton_legs.png', 'offset' => '0', 'type' => '3', 'character_id' => '[15]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots'],
                ['id' => '303', 'src' => 'sword-0_974536_char.png', 'offset' => '0', 'type' => '4', 'character_id' => '[15]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'sword'],
                ['id' => '304', 'src' => 'shield-0_0762db6a6a.png', 'offset' => '0', 'type' => '5', 'character_id' => '[15]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'shield'],

                ['id' => '310', 'src' => 'aquatic/atlantis-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[16]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots-atlantis'],
                ['id' => '311', 'src' => 'aquatic/atlantis-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '[16]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'boots-atlantis'],
                ['id' => '312', 'src' => 'aquatic/atlantis-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '[16]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '400', 'classes' => 'boots-atlantis'],
                ['id' => '313', 'src' => 'aquatic/atlantis-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '[16]', 'hp' => '20', 'xp' => '0', 'gold' => '0', 'price' => '600', 'classes' => 'boots-atlantis'],

                ['id' => '314', 'src' => 'aquatic/atlantis-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '[16]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-right-atlantis'],
                ['id' => '315', 'src' => 'aquatic/atlantis-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '[16]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-right-atlantis'],
                ['id' => '316', 'src' => 'aquatic/atlantis-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[16]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-right-atlantis'],
                ['id' => '317', 'src' => 'aquatic/atlantis-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '[16]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-right-atlantis'],

                ['id' => '318', 'src' => 'aquatic/atlantis-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '[16]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-left-atlantis'],
                ['id' => '319', 'src' => 'aquatic/atlantis-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '[16]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-left-atlantis'],
                ['id' => '320', 'src' => 'aquatic/atlantis-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '[16]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-left-atlantis'],
                ['id' => '321', 'src' => 'aquatic/atlantis-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '[16]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-left-atlantis'],

                ['id' => '322', 'src' => 'aquatic/atlantis-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[16]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet-atlantis'],
                ['id' => '323', 'src' => 'aquatic/atlantis-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '[16]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'helmet-atlantis'],
                ['id' => '324', 'src' => 'aquatic/atlantis-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[16]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'helmet-atlantis'],
                ['id' => '325', 'src' => 'aquatic/atlantis-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '[16]', 'hp' => '0', 'xp' => '30', 'gold' => '0', 'price' => '800', 'classes' => 'helmet-atlantis'],

                ['id' => '326', 'src' => 'aquatic/atlantis-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[16]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor-atlantis'],
                ['id' => '327', 'src' => 'aquatic/atlantis-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[16]', 'hp' => '5', 'xp' => '5', 'gold' => '5', 'price' => '500', 'classes' => 'armor-atlantis'],
                ['id' => '328', 'src' => 'aquatic/atlantis-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[16]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '800', 'classes' => 'armor-atlantis'],
                ['id' => '329', 'src' => 'aquatic/atlantis-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[16]', 'hp' => '40', 'xp' => '0', 'gold' => '40', 'price' => '1000', 'classes' => 'armor-atlantis'],

                ['id' => '330', 'src' => 'aquatic/desertor-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[17]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'boots-desertores'],
                ['id' => '331', 'src' => 'aquatic/desertor-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '[17]', 'hp' => '5', 'gold' => '0', 'xp' => '0', 'price' => '200', 'classes' => 'boots-desertores'],
                ['id' => '332', 'src' => 'aquatic/desertor-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '[17]', 'hp' => '10', 'gold' => '0', 'xp' => '0', 'price' => '400', 'classes' => 'boots-desertores'],
                ['id' => '333', 'src' => 'aquatic/desertor-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '[17]', 'hp' => '20', 'gold' => '0', 'xp' => '0', 'price' => '600', 'classes' => 'boots-desertores'],

                ['id' => '334', 'src' => 'aquatic/desertor-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '[17]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-right-desertores'],
                ['id' => '335', 'src' => 'aquatic/desertor-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '[17]', 'hp' => '0', 'gold' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-right-desertores'],
                ['id' => '336', 'src' => 'aquatic/desertor-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[17]', 'hp' => '0', 'gold' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-right-desertores'],
                ['id' => '337', 'src' => 'aquatic/desertor-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '[17]', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-right-desertores'],

                ['id' => '338', 'src' => 'aquatic/desertor-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '[17]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-left-desertores'],
                ['id' => '339', 'src' => 'aquatic/desertor-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '[17]', 'hp' => '0', 'gold' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-left-desertores'],
                ['id' => '340', 'src' => 'aquatic/desertor-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '[17]', 'hp' => '0', 'gold' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-left-desertores'],
                ['id' => '341', 'src' => 'aquatic/desertor-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '[17]', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-left-desertores'],

                ['id' => '342', 'src' => 'aquatic/desertor-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[17]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'helmet-desertores'],
                ['id' => '343', 'src' => 'aquatic/desertor-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '[17]', 'hp' => '0', 'gold' => '5', 'xp' => '5', 'price' => '400', 'classes' => 'helmet-desertores'],
                ['id' => '344', 'src' => 'aquatic/desertor-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[17]', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'helmet-desertores'],
                ['id' => '345', 'src' => 'aquatic/desertor-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '[17]', 'hp' => '0', 'gold' => '30', 'xp' => '0', 'price' => '800', 'classes' => 'helmet-desertores'],

                ['id' => '346', 'src' => 'aquatic/desertor-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[17]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'armor-desertores'],
                ['id' => '347', 'src' => 'aquatic/desertor-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[17]', 'hp' => '5', 'gold' => '5', 'xp' => '5', 'price' => '500', 'classes' => 'armor-desertores'],
                ['id' => '348', 'src' => 'aquatic/desertor-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[17]', 'hp' => '15', 'gold' => '0', 'xp' => '15', 'price' => '800', 'classes' => 'armor-desertores'],
                ['id' => '349', 'src' => 'aquatic/desertor-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[17]', 'hp' => '40', 'gold' => '0', 'xp' => '40', 'price' => '1000', 'classes' => 'armor-desertores'],

                ['id' => '350', 'src' => 'aquatic/fosa-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[18]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'boots-fosa'],
                ['id' => '351', 'src' => 'aquatic/fosa-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '[18]', 'gold' => '5', 'hp' => '0', 'xp' => '0', 'price' => '200', 'classes' => 'boots-fosa'],
                ['id' => '352', 'src' => 'aquatic/fosa-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '[18]', 'gold' => '10', 'hp' => '0', 'xp' => '0', 'price' => '400', 'classes' => 'boots-fosa'],
                ['id' => '353', 'src' => 'aquatic/fosa-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '[18]', 'gold' => '20', 'hp' => '0', 'xp' => '0', 'price' => '600', 'classes' => 'boots-fosa'],

                ['id' => '354', 'src' => 'aquatic/fosa-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '[18]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-right-fosa'],
                ['id' => '355', 'src' => 'aquatic/fosa-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '[18]', 'gold' => '0', 'hp' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-right-fosa'],
                ['id' => '356', 'src' => 'aquatic/fosa-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[18]', 'gold' => '0', 'hp' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-right-fosa'],
                ['id' => '357', 'src' => 'aquatic/fosa-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '[18]', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-right-fosa'],

                ['id' => '358', 'src' => 'aquatic/fosa-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '[18]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-left-fosa'],
                ['id' => '359', 'src' => 'aquatic/fosa-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '[18]', 'gold' => '0', 'hp' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-left-fosa'],
                ['id' => '360', 'src' => 'aquatic/fosa-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '[18]', 'gold' => '0', 'hp' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-left-fosa'],
                ['id' => '361', 'src' => 'aquatic/fosa-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '[18]', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-left-fosa'],

                ['id' => '362', 'src' => 'aquatic/fosa-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[18]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'helmet-fosa'],
                ['id' => '363', 'src' => 'aquatic/fosa-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '[18]', 'gold' => '0', 'hp' => '5', 'xp' => '5', 'price' => '400', 'classes' => 'helmet-fosa'],
                ['id' => '364', 'src' => 'aquatic/fosa-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[18]', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'helmet-fosa'],
                ['id' => '365', 'src' => 'aquatic/fosa-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '[18]', 'gold' => '0', 'hp' => '30', 'xp' => '0', 'price' => '800', 'classes' => 'helmet-fosa'],

                ['id' => '366', 'src' => 'aquatic/fosa-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[18]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'armor-fosa'],
                ['id' => '367', 'src' => 'aquatic/fosa-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[18]', 'gold' => '5', 'hp' => '5', 'xp' => '5', 'price' => '500', 'classes' => 'armor-fosa'],
                ['id' => '368', 'src' => 'aquatic/fosa-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[18]', 'gold' => '15', 'hp' => '0', 'xp' => '15', 'price' => '800', 'classes' => 'armor-fosa'],
                ['id' => '369', 'src' => 'aquatic/fosa-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[18]', 'gold' => '40', 'hp' => '0', 'xp' => '40', 'price' => '1000', 'classes' => 'armor-fosa'],

                ['id' => '370', 'src' => 'aquatic/mar-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[19]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'boots-mar'],
                ['id' => '371', 'src' => 'aquatic/mar-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '[19]', 'hp' => '5', 'gold' => '0', 'xp' => '0', 'price' => '200', 'classes' => 'boots-mar'],
                ['id' => '372', 'src' => 'aquatic/mar-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '[19]', 'hp' => '10', 'gold' => '0', 'xp' => '0', 'price' => '400', 'classes' => 'boots-mar'],
                ['id' => '373', 'src' => 'aquatic/mar-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '[19]', 'hp' => '20', 'gold' => '0', 'xp' => '0', 'price' => '600', 'classes' => 'boots-mar'],

                ['id' => '374', 'src' => 'aquatic/mar-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '[19]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-right-mar'],
                ['id' => '375', 'src' => 'aquatic/mar-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '[19]', 'hp' => '0', 'gold' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-right-mar'],
                ['id' => '376', 'src' => 'aquatic/mar-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[19]', 'hp' => '0', 'gold' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-right-mar'],
                ['id' => '377', 'src' => 'aquatic/mar-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '[19]', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-right-mar'],

                ['id' => '378', 'src' => 'aquatic/mar-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '[19]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-left-mar'],
                ['id' => '379', 'src' => 'aquatic/mar-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '[19]', 'hp' => '0', 'gold' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-left-mar'],
                ['id' => '380', 'src' => 'aquatic/mar-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '[19]', 'hp' => '0', 'gold' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-left-mar'],
                ['id' => '381', 'src' => 'aquatic/mar-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '[19]', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-left-mar'],

                ['id' => '382', 'src' => 'aquatic/mar-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[19]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'helmet-mar'],
                ['id' => '383', 'src' => 'aquatic/mar-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '[19]', 'hp' => '0', 'gold' => '5', 'xp' => '5', 'price' => '400', 'classes' => 'helmet-mar'],
                ['id' => '384', 'src' => 'aquatic/mar-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[19]', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'helmet-mar'],
                ['id' => '385', 'src' => 'aquatic/mar-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '[19]', 'hp' => '0', 'gold' => '30', 'xp' => '0', 'price' => '800', 'classes' => 'helmet-mar'],

                ['id' => '386', 'src' => 'aquatic/mar-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[19]', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'armor-mar'],
                ['id' => '387', 'src' => 'aquatic/mar-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[19]', 'hp' => '5', 'gold' => '5', 'xp' => '5', 'price' => '500', 'classes' => 'armor-mar'],
                ['id' => '388', 'src' => 'aquatic/mar-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[19]', 'hp' => '15', 'gold' => '0', 'xp' => '15', 'price' => '800', 'classes' => 'armor-mar'],
                ['id' => '389', 'src' => 'aquatic/mar-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[19]', 'hp' => '40', 'gold' => '0', 'xp' => '40', 'price' => '1000', 'classes' => 'armor-mar'],



                ['id' => '390', 'src' => 'aquatic/pescadores-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[20]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'boots-pescadores'],
                ['id' => '391', 'src' => 'aquatic/pescadores-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '[20]', 'gold' => '5', 'hp' => '0', 'xp' => '0', 'price' => '200', 'classes' => 'boots-pescadores'],
                ['id' => '392', 'src' => 'aquatic/pescadores-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '[20]', 'gold' => '10', 'hp' => '0', 'xp' => '0', 'price' => '400', 'classes' => 'boots-pescadores'],
                ['id' => '393', 'src' => 'aquatic/pescadores-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '[20]', 'gold' => '20', 'hp' => '0', 'xp' => '0', 'price' => '600', 'classes' => 'boots-pescadores'],

                ['id' => '394', 'src' => 'aquatic/pescadores-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '[20]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-right-pescadores'],
                ['id' => '395', 'src' => 'aquatic/pescadores-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '[20]', 'gold' => '0', 'hp' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-right-pescadores'],
                ['id' => '396', 'src' => 'aquatic/pescadores-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[20]', 'gold' => '0', 'hp' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-right-pescadores'],
                ['id' => '397', 'src' => 'aquatic/pescadores-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '[20]', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-right-pescadores'],

                ['id' => '398', 'src' => 'aquatic/pescadores-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '[20]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-left-pescadores'],
                ['id' => '399', 'src' => 'aquatic/pescadores-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '[20]', 'gold' => '0', 'hp' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-left-pescadores'],
                ['id' => '400', 'src' => 'aquatic/pescadores-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '[20]', 'gold' => '0', 'hp' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-left-pescadores'],
                ['id' => '401', 'src' => 'aquatic/pescadores-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '[20]', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-left-pescadores'],

                ['id' => '402', 'src' => 'aquatic/pescadores-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[20]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'helmet-pescadores'],
                ['id' => '403', 'src' => 'aquatic/pescadores-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '[20]', 'gold' => '0', 'hp' => '5', 'xp' => '5', 'price' => '400', 'classes' => 'helmet-pescadores'],
                ['id' => '404', 'src' => 'aquatic/pescadores-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[20]', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'helmet-pescadores'],
                ['id' => '405', 'src' => 'aquatic/pescadores-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '[20]', 'gold' => '0', 'hp' => '30', 'xp' => '0', 'price' => '800', 'classes' => 'helmet-pescadores'],

                ['id' => '406', 'src' => 'aquatic/pescadores-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[20]', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'armor-pescadores'],
                ['id' => '407', 'src' => 'aquatic/pescadores-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[20]', 'gold' => '5', 'hp' => '5', 'xp' => '5', 'price' => '500', 'classes' => 'armor-pescadores'],
                ['id' => '408', 'src' => 'aquatic/pescadores-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[20]', 'gold' => '15', 'hp' => '0', 'xp' => '15', 'price' => '800', 'classes' => 'armor-pescadores'],
                ['id' => '409', 'src' => 'aquatic/pescadores-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[20]', 'gold' => '40', 'hp' => '0', 'xp' => '40', 'price' => '1000', 'classes' => 'armor-pescadores'],



                ['id' => '410', 'src' => 'aquatic/salmuera-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[21]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots-salmuera'],
                ['id' => '411', 'src' => 'aquatic/salmuera-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '[21]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'boots-salmuera'],
                ['id' => '412', 'src' => 'aquatic/salmuera-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '[21]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '400', 'classes' => 'boots-salmuera'],
                ['id' => '413', 'src' => 'aquatic/salmuera-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '[21]', 'hp' => '20', 'xp' => '0', 'gold' => '0', 'price' => '600', 'classes' => 'boots-salmuera'],

                ['id' => '414', 'src' => 'aquatic/salmuera-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '[21]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-right-salmuera'],
                ['id' => '415', 'src' => 'aquatic/salmuera-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '[21]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-right-salmuera'],
                ['id' => '416', 'src' => 'aquatic/salmuera-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[21]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-right-salmuera'],
                ['id' => '417', 'src' => 'aquatic/salmuera-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '[21]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-right-salmuera'],

                ['id' => '418', 'src' => 'aquatic/salmuera-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '[21]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-left-salmuera'],
                ['id' => '419', 'src' => 'aquatic/salmuera-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '[21]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-left-salmuera'],
                ['id' => '420', 'src' => 'aquatic/salmuera-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '[21]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-left-salmuera'],
                ['id' => '421', 'src' => 'aquatic/salmuera-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '[21]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-left-salmuera'],

                ['id' => '422', 'src' => 'aquatic/salmuera-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[21]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet-salmuera'],
                ['id' => '423', 'src' => 'aquatic/salmuera-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '[21]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'helmet-salmuera'],
                ['id' => '424', 'src' => 'aquatic/salmuera-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[21]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'helmet-salmuera'],
                ['id' => '425', 'src' => 'aquatic/salmuera-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '[21]', 'hp' => '0', 'xp' => '30', 'gold' => '0', 'price' => '800', 'classes' => 'helmet-salmuera'],

                ['id' => '426', 'src' => 'aquatic/salmuera-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[21]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor-salmuera'],
                ['id' => '427', 'src' => 'aquatic/salmuera-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[21]', 'hp' => '5', 'xp' => '5', 'gold' => '5', 'price' => '500', 'classes' => 'armor-salmuera'],
                ['id' => '428', 'src' => 'aquatic/salmuera-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[21]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '800', 'classes' => 'armor-salmuera'],
                ['id' => '429', 'src' => 'aquatic/salmuera-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[21]', 'hp' => '40', 'xp' => '0', 'gold' => '40', 'price' => '1000', 'classes' => 'armor-salmuera'],

                ['id' => '430', 'src' => 'aquatic/xebel-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '[22]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots-xebel'],
                ['id' => '431', 'src' => 'aquatic/xebel-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '[22]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'boots-xebel'],
                ['id' => '432', 'src' => 'aquatic/xebel-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '[22]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '400', 'classes' => 'boots-xebel'],
                ['id' => '433', 'src' => 'aquatic/xebel-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '[22]', 'hp' => '20', 'xp' => '0', 'gold' => '0', 'price' => '600', 'classes' => 'boots-xebel'],

                ['id' => '434', 'src' => 'aquatic/xebel-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '[22]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-right-xebel'],
                ['id' => '435', 'src' => 'aquatic/xebel-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '[22]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-right-xebel'],
                ['id' => '436', 'src' => 'aquatic/xebel-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '[22]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-right-xebel'],
                ['id' => '437', 'src' => 'aquatic/xebel-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '[22]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-right-xebel'],

                ['id' => '438', 'src' => 'aquatic/xebel-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '[22]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-left-xebel'],
                ['id' => '439', 'src' => 'aquatic/xebel-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '[22]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-left-xebel'],
                ['id' => '440', 'src' => 'aquatic/xebel-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '[22]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-left-xebel'],
                ['id' => '441', 'src' => 'aquatic/xebel-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '[22]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-left-xebel'],

                ['id' => '442', 'src' => 'aquatic/xebel-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[22]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet-xebel'],
                ['id' => '443', 'src' => 'aquatic/xebel-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '[22]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'helmet-xebel'],
                ['id' => '444', 'src' => 'aquatic/xebel-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '[22]', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'helmet-xebel'],
                ['id' => '445', 'src' => 'aquatic/xebel-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '[22]', 'hp' => '0', 'xp' => '30', 'gold' => '0', 'price' => '800', 'classes' => 'helmet-xebel'],

                ['id' => '446', 'src' => 'aquatic/xebel-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '[22]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor-xebel'],
                ['id' => '447', 'src' => 'aquatic/xebel-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '[22]', 'hp' => '5', 'xp' => '5', 'gold' => '5', 'price' => '500', 'classes' => 'armor-xebel'],
                ['id' => '448', 'src' => 'aquatic/xebel-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '[22]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '800', 'classes' => 'armor-xebel'],
                ['id' => '449', 'src' => 'aquatic/xebel-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '[22]', 'hp' => '40', 'xp' => '0', 'gold' => '40', 'price' => '1000', 'classes' => 'armor-xebel'],

                // Archer
                ['id' => '450', 'src' => 'fantasy/archer_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[23]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'archer-body'],
                ['id' => '451', 'src' => 'fantasy/archer_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[23]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'archer-body'],
                ['id' => '452', 'src' => 'fantasy/archer_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[23]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'archer-body'],
                ['id' => '453', 'src' => 'fantasy/archer_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[23]', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'archer-body'],

                ['id' => '454', 'src' => 'fantasy/archer_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[23]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'archer-head'],
                ['id' => '455', 'src' => 'fantasy/archer_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[23]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'archer-head'],
                ['id' => '456', 'src' => 'fantasy/archer_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[23]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'archer-head'],
                ['id' => '457', 'src' => 'fantasy/archer_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[23]', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '1000', 'classes' => 'archer-head'],

                ['id' => '458', 'src' => 'fantasy/archer_bow_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[23]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'archer-bow'],
                ['id' => '459', 'src' => 'fantasy/archer_bow_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[23]', 'hp' => '0', 'xp' => '15', 'gold' => '5', 'price' => '700', 'classes' => 'archer-bow'],
                ['id' => '460', 'src' => 'fantasy/archer_bow_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[23]', 'hp' => '5', 'xp' => '15', 'gold' => '10', 'price' => '1400', 'classes' => 'archer-bow'],
                ['id' => '461', 'src' => 'fantasy/archer_bow_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[23]', 'hp' => '15', 'xp' => '20', 'gold' => '20', 'price' => '2000', 'classes' => 'archer-bow'],

                ['id' => '462', 'src' => 'fantasy/archer_arrow_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '[23]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'archer-arrow'],
                ['id' => '463', 'src' => 'fantasy/archer_arrow_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '[23]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'archer-arrow'],
                ['id' => '464', 'src' => 'fantasy/archer_arrow_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '[23]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '400', 'classes' => 'archer-arrow'],
                ['id' => '465', 'src' => 'fantasy/archer_arrow_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '[23]', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'archer-arrow'],

                // Wizard
                ['id' => '470', 'src' => 'fantasy/wraith_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[24]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'wraith-body'],
                ['id' => '471', 'src' => 'fantasy/wraith_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[24]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'wraith-body'],
                ['id' => '472', 'src' => 'fantasy/wraith_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[24]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'wraith-body'],
                ['id' => '473', 'src' => 'fantasy/wraith_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[24]', 'hp' => '10', 'xp' => '10', 'gold' => '15', 'price' => '600', 'classes' => 'wraith-body'],

                ['id' => '474', 'src' => 'fantasy/wraith_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[24]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'wraith-head'],
                ['id' => '475', 'src' => 'fantasy/wraith_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[24]', 'hp' => '0', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'wraith-head'],
                ['id' => '476', 'src' => 'fantasy/wraith_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[24]', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '800', 'classes' => 'wraith-head'],
                ['id' => '477', 'src' => 'fantasy/wraith_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[24]', 'hp' => '15', 'xp' => '10', 'gold' => '15', 'price' => '1000', 'classes' => 'wraith-head'],

                ['id' => '478', 'src' => 'fantasy/wraith_ball_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[24]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'wraith-ball'],
                ['id' => '479', 'src' => 'fantasy/wraith_ball_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[24]', 'hp' => '0', 'xp' => '5', 'gold' => '15', 'price' => '700', 'classes' => 'wraith-ball'],
                ['id' => '480', 'src' => 'fantasy/wraith_ball_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[24]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1400', 'classes' => 'wraith-ball'],
                ['id' => '481', 'src' => 'fantasy/wraith_ball_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[24]', 'hp' => '15', 'xp' => '20', 'gold' => '20', 'price' => '2000', 'classes' => 'wraith-ball'],

                ['id' => '482', 'src' => 'fantasy/wraith_arms_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '[24]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'wraith-arms'],
                ['id' => '483', 'src' => 'fantasy/wraith_arms_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '[24]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'wraith-arms'],
                ['id' => '484', 'src' => 'fantasy/wraith_arms_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '[24]', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '400', 'classes' => 'wraith-arms'],
                ['id' => '485', 'src' => 'fantasy/wraith_arms_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '[24]', 'hp' => '10', 'xp' => '10', 'gold' => '15', 'price' => '600', 'classes' => 'wraith-arms'],

                // Knight
                ['id' => '490', 'src' => 'fantasy/knight_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[25]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'knight-body'],
                ['id' => '491', 'src' => 'fantasy/knight_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[25]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'knight-body'],
                ['id' => '492', 'src' => 'fantasy/knight_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[25]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'knight-body'],
                ['id' => '493', 'src' => 'fantasy/knight_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[25]', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'knight-body'],

                ['id' => '494', 'src' => 'fantasy/knight_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[25]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'knight-head'],
                ['id' => '495', 'src' => 'fantasy/knight_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[25]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '400', 'classes' => 'knight-head'],
                ['id' => '496', 'src' => 'fantasy/knight_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[25]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'knight-head'],
                ['id' => '497', 'src' => 'fantasy/knight_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[25]', 'hp' => '15', 'xp' => '10', 'gold' => '10', 'price' => '1000', 'classes' => 'knight-head'],

                ['id' => '498', 'src' => 'fantasy/knight_sword_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[25]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'knight-sword'],
                ['id' => '499', 'src' => 'fantasy/knight_sword_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[25]', 'hp' => '15', 'xp' => '0', 'gold' => '5', 'price' => '700', 'classes' => 'knight-sword'],
                ['id' => '500', 'src' => 'fantasy/knight_sword_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[25]', 'hp' => '15', 'xp' => '5', 'gold' => '10', 'price' => '1400', 'classes' => 'knight-sword'],
                ['id' => '501', 'src' => 'fantasy/knight_sword_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[25]', 'hp' => '20', 'xp' => '15', 'gold' => '20', 'price' => '2000', 'classes' => 'knight-sword'],

                ['id' => '502', 'src' => 'fantasy/knight_shield_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '[25]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'knight-shield'],
                ['id' => '503', 'src' => 'fantasy/knight_shield_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '[25]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'knight-shield'],
                ['id' => '504', 'src' => 'fantasy/knight_shield_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '[25]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'knight-shield'],
                ['id' => '505', 'src' => 'fantasy/knight_shield_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '[25]', 'hp' => '15', 'xp' => '10', 'gold' => '10', 'price' => '600', 'classes' => 'knight-shield'],

                ['id' => '510', 'src' => 'fantasy/skeleton_head.png', 'offset' => '0', 'type' => '0', 'character_id' => '[26]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'skeleton-head'],
                ['id' => '511', 'src' => 'fantasy/skeleton_arms.png', 'offset' => '0', 'type' => '1', 'character_id' => '[26]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'skeleton-arms'],
                ['id' => '512', 'src' => 'fantasy/skeleton_body.png', 'offset' => '0', 'type' => '2', 'character_id' => '[26]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'skeleton-body'],
                ['id' => '513', 'src' => 'fantasy/skeleton_legs.png', 'offset' => '0', 'type' => '3', 'character_id' => '[26]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'skeleton-legs'],

                // a1
                ['id' => '520', 'src' => 'space/a1_cape_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[27]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a1-cape'],
                ['id' => '521', 'src' => 'space/a1_cape_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[27]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute a1-cape'],
                ['id' => '522', 'src' => 'space/a1_cape_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[27]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1000', 'classes' => 'is-absolute a1-cape'],
                ['id' => '523', 'src' => 'space/a1_cape_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[27]', 'hp' => '15', 'xp' => '20', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute a1-cape'],
                ['id' => '524', 'src' => 'space/a1_body_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[27]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a1-body'],
                ['id' => '525', 'src' => 'space/a1_body_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[27]', 'hp' => '0', 'xp' => '5', 'gold' => '15', 'price' => '700', 'classes' => 'is-absolute a1-body'],
                ['id' => '526', 'src' => 'space/a1_body_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[27]', 'hp' => '10', 'xp' => '5', 'gold' => '15', 'price' => '800', 'classes' => 'is-absolute a1-body'],
                ['id' => '527', 'src' => 'space/a1_body_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[27]', 'hp' => '15', 'xp' => '20', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute a1-body'],
                ['id' => '528', 'src' => 'space/a1_head_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[27]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a1-head'],
                ['id' => '529', 'src' => 'space/a1_head_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[27]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute a1-head'],
                ['id' => '530', 'src' => 'space/a1_head_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[27]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute a1-head'],
                ['id' => '531', 'src' => 'space/a1_head_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[27]', 'hp' => '20', 'xp' => '40', 'gold' => '20', 'price' => '1600', 'classes' => 'is-absolute a1-head'],

                // a2
                ['id' => '540', 'src' => 'space/a2_cape_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[28]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a2-cape'],
                ['id' => '541', 'src' => 'space/a2_cape_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[28]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute a2-cape'],
                ['id' => '542', 'src' => 'space/a2_cape_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[28]', 'hp' => '15', 'xp' => '5', 'gold' => '10', 'price' => '1000', 'classes' => 'is-absolute a2-cape'],
                ['id' => '543', 'src' => 'space/a2_cape_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[28]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '1200', 'classes' => 'is-absolute a2-cape'],
                ['id' => '544', 'src' => 'space/a2_body_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[28]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a2-body'],
                ['id' => '545', 'src' => 'space/a2_body_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[28]', 'hp' => '15', 'xp' => '0', 'gold' => '5', 'price' => '700', 'classes' => 'is-absolute a2-body'],
                ['id' => '546', 'src' => 'space/a2_body_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[28]', 'hp' => '15', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'is-absolute a2-body'],
                ['id' => '547', 'src' => 'space/a2_body_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[28]', 'hp' => '10', 'xp' => '15', 'gold' => '20', 'price' => '1200', 'classes' => 'is-absolute a2-body'],
                ['id' => '548', 'src' => 'space/a2_head_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[28]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a2-head'],
                ['id' => '549', 'src' => 'space/a2_head_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[28]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '400', 'classes' => 'is-absolute a2-head'],
                ['id' => '550', 'src' => 'space/a2_head_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[28]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute a2-head'],
                ['id' => '551', 'src' => 'space/a2_head_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[28]', 'hp' => '20', 'xp' => '20', 'gold' => '40', 'price' => '1600', 'classes' => 'is-absolute a2-head'],

                //a3
                ['id' => '560', 'src' => 'space/a3_cape_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[29]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a3-cape'],
                ['id' => '561', 'src' => 'space/a3_cape_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[29]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute a3-cape'],
                ['id' => '562', 'src' => 'space/a3_cape_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[29]', 'hp' => '10', 'xp' => '5', 'gold' => '15', 'price' => '1000', 'classes' => 'is-absolute a3-cape'],
                ['id' => '563', 'src' => 'space/a3_cape_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[29]', 'hp' => '20', 'xp' => '15', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute a3-cape'],
                ['id' => '564', 'src' => 'space/a3_body_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[29]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a3-body'],
                ['id' => '565', 'src' => 'space/a3_body_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[29]', 'hp' => '5', 'xp' => '0', 'gold' => '15', 'price' => '700', 'classes' => 'is-absolute a3-body'],
                ['id' => '566', 'src' => 'space/a3_body_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[29]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '800', 'classes' => 'is-absolute a3-body'],
                ['id' => '567', 'src' => 'space/a3_body_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[29]', 'hp' => '20', 'xp' => '15', 'gold' => '10', 'price' => '1200', 'classes' => 'is-absolute a3-body'],
                ['id' => '568', 'src' => 'space/a3_head_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[29]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'is-absolute a3-head'],
                ['id' => '569', 'src' => 'space/a3_head_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[29]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'is-absolute a3-head'],
                ['id' => '570', 'src' => 'space/a3_head_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[29]', 'hp' => '10', 'xp' => '10', 'gold' => '10', 'price' => '800', 'classes' => 'is-absolute a3-head'],
                ['id' => '571', 'src' => 'space/a3_head_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[29]', 'hp' => '40', 'xp' => '20', 'gold' => '20', 'price' => '1600', 'classes' => 'is-absolute a3-head'],

                // fairy
                ['id' => '580', 'src' => 'fantasy/fairy_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[30]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'fairy-body'],
                ['id' => '581', 'src' => 'fantasy/fairy_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[30]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'fairy-body'],
                ['id' => '582', 'src' => 'fantasy/fairy_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[30]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'fairy-body'],
                ['id' => '583', 'src' => 'fantasy/fairy_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[30]', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'fairy-body'],

                ['id' => '584', 'src' => 'fantasy/fairy_wings_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[30]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'fairy-wings'],
                ['id' => '585', 'src' => 'fantasy/fairy_wings_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[30]', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'fairy-wings'],
                ['id' => '586', 'src' => 'fantasy/fairy_wings_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[30]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'fairy-wings'],
                ['id' => '587', 'src' => 'fantasy/fairy_wings_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[30]', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '1000', 'classes' => 'fairy-wings'],

                ['id' => '588', 'src' => 'fantasy/fairy_wand_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[30]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'fairy-wand'],
                ['id' => '589', 'src' => 'fantasy/fairy_wand_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[30]', 'hp' => '0', 'xp' => '15', 'gold' => '5', 'price' => '700', 'classes' => 'fairy-wand'],
                ['id' => '590', 'src' => 'fantasy/fairy_wand_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[30]', 'hp' => '5', 'xp' => '15', 'gold' => '10', 'price' => '1400', 'classes' => 'fairy-wand'],
                ['id' => '591', 'src' => 'fantasy/fairy_wand_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[30]', 'hp' => '15', 'xp' => '20', 'gold' => '20', 'price' => '2000', 'classes' => 'fairy-wand'],

                ['id' => '592', 'src' => 'fantasy/fairy_ball_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '[30]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'fairy-ball'],
                ['id' => '593', 'src' => 'fantasy/fairy_ball_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '[30]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'fairy-ball'],
                ['id' => '594', 'src' => 'fantasy/fairy_ball_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '[30]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '400', 'classes' => 'fairy-ball'],
                ['id' => '595', 'src' => 'fantasy/fairy_ball_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '[30]', 'hp' => '10', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'fairy-ball'],

                // mummy
                ['id' => '600', 'src' => 'fantasy/mummy_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[31]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'mummy-body'],
                ['id' => '601', 'src' => 'fantasy/mummy_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[31]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'mummy-body'],
                ['id' => '602', 'src' => 'fantasy/mummy_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[31]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'mummy-body'],
                ['id' => '603', 'src' => 'fantasy/mummy_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[31]', 'hp' => '10', 'xp' => '10', 'gold' => '15', 'price' => '600', 'classes' => 'mummy-body'],

                ['id' => '604', 'src' => 'fantasy/mummy_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[31]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'mummy-head'],
                ['id' => '605', 'src' => 'fantasy/mummy_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[31]', 'hp' => '0', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'mummy-head'],
                ['id' => '606', 'src' => 'fantasy/mummy_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[31]', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '800', 'classes' => 'mummy-head'],
                ['id' => '607', 'src' => 'fantasy/mummy_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[31]', 'hp' => '15', 'xp' => '10', 'gold' => '15', 'price' => '1000', 'classes' => 'mummy-head'],

                ['id' => '608', 'src' => 'fantasy/mummy_weapon_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[31]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'mummy-weapon'],
                ['id' => '609', 'src' => 'fantasy/mummy_weapon_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[31]', 'hp' => '0', 'xp' => '5', 'gold' => '15', 'price' => '700', 'classes' => 'mummy-weapon'],
                ['id' => '610', 'src' => 'fantasy/mummy_weapon_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[31]', 'hp' => '5', 'xp' => '10', 'gold' => '15', 'price' => '1400', 'classes' => 'mummy-weapon'],
                ['id' => '611', 'src' => 'fantasy/mummy_weapon_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[31]', 'hp' => '15', 'xp' => '20', 'gold' => '20', 'price' => '2000', 'classes' => 'mummy-weapon'],

                ['id' => '612', 'src' => 'fantasy/mummy_shield_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '[31]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'mummy-shield'],
                ['id' => '613', 'src' => 'fantasy/mummy_shield_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '[31]', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'mummy-shield'],
                ['id' => '614', 'src' => 'fantasy/mummy_shield_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '[31]', 'hp' => '5', 'xp' => '5', 'gold' => '10', 'price' => '400', 'classes' => 'mummy-shield'],
                ['id' => '615', 'src' => 'fantasy/mummy_shield_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '[31]', 'hp' => '10', 'xp' => '10', 'gold' => '15', 'price' => '600', 'classes' => 'mummy-shield'],

                // golem
                ['id' => '620', 'src' => 'fantasy/golem_body_0.png', 'offset' => '0', 'type' => '0', 'character_id' => '[32]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'golem-body'],
                ['id' => '621', 'src' => 'fantasy/golem_body_1.png', 'offset' => '1', 'type' => '0', 'character_id' => '[32]', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'golem-body'],
                ['id' => '622', 'src' => 'fantasy/golem_body_2.png', 'offset' => '2', 'type' => '0', 'character_id' => '[32]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'golem-body'],
                ['id' => '623', 'src' => 'fantasy/golem_body_3.png', 'offset' => '3', 'type' => '0', 'character_id' => '[32]', 'hp' => '15', 'xp' => '15', 'gold' => '10', 'price' => '600', 'classes' => 'golem-body'],

                ['id' => '624', 'src' => 'fantasy/golem_head_0.png', 'offset' => '0', 'type' => '1', 'character_id' => '[32]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'golem-head'],
                ['id' => '625', 'src' => 'fantasy/golem_head_1.png', 'offset' => '1', 'type' => '1', 'character_id' => '[32]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '400', 'classes' => 'golem-head'],
                ['id' => '626', 'src' => 'fantasy/golem_head_2.png', 'offset' => '2', 'type' => '1', 'character_id' => '[32]', 'hp' => '5', 'xp' => '10', 'gold' => '5', 'price' => '800', 'classes' => 'golem-head'],
                ['id' => '627', 'src' => 'fantasy/golem_head_3.png', 'offset' => '3', 'type' => '1', 'character_id' => '[32]', 'hp' => '15', 'xp' => '10', 'gold' => '10', 'price' => '1000', 'classes' => 'golem-head'],

                ['id' => '628', 'src' => 'fantasy/golem_weapon_0.png', 'offset' => '0', 'type' => '2', 'character_id' => '[32]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'golem-weapon'],
                ['id' => '629', 'src' => 'fantasy/golem_weapon_1.png', 'offset' => '1', 'type' => '2', 'character_id' => '[32]', 'hp' => '15', 'xp' => '0', 'gold' => '5', 'price' => '700', 'classes' => 'golem-weapon'],
                ['id' => '630', 'src' => 'fantasy/golem_weapon_2.png', 'offset' => '2', 'type' => '2', 'character_id' => '[32]', 'hp' => '15', 'xp' => '5', 'gold' => '10', 'price' => '1400', 'classes' => 'golem-weapon'],
                ['id' => '631', 'src' => 'fantasy/golem_weapon_3.png', 'offset' => '3', 'type' => '2', 'character_id' => '[32]', 'hp' => '20', 'xp' => '15', 'gold' => '20', 'price' => '2000', 'classes' => 'golem-weapon'],

                ['id' => '632', 'src' => 'fantasy/golem_bottom_0.png', 'offset' => '0', 'type' => '3', 'character_id' => '[32]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'golem-bottom'],
                ['id' => '633', 'src' => 'fantasy/golem_bottom_1.png', 'offset' => '1', 'type' => '3', 'character_id' => '[32]', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'golem-bottom'],
                ['id' => '634', 'src' => 'fantasy/golem_bottom_2.png', 'offset' => '2', 'type' => '3', 'character_id' => '[32]', 'hp' => '10', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'golem-bottom'],
                ['id' => '635', 'src' => 'fantasy/golem_bottom_3.png', 'offset' => '3', 'type' => '3', 'character_id' => '[32]', 'hp' => '15', 'xp' => '10', 'gold' => '10', 'price' => '600', 'classes' => 'golem-bottom'],

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
        Schema::dropIfExists('equipment');
    }
}
