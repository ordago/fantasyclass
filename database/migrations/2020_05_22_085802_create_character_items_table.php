<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id');
            $table->string('src', 100);
            $table->smallInteger('type');
            $table->smallInteger('hp');
            $table->smallInteger('xp');
            $table->smallInteger('gold');
            $table->smallInteger('price');
            $table->smallInteger('offset');
            $table->string('classes');
        });
        DB::table('equipment')->insert(
            [ 
                ['id' => '1','src' => 'boots-0_75d4eab23.png', 'offset' => '0' ,'type' => '0','character_id' => '0','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'boots'],
                ['id' => '2','src' => 'boots-1_cf6b23.png', 'offset' => '1' ,'type' => '0','character_id' => '0','hp' => '5','xp' => '0','gold' => '0','price' => '150', 'classes' => 'boots'],
                ['id' => '3','src' => 'boots-2_cf69ab23.png', 'offset' => '2' ,'type' => '0','character_id' => '0','hp' => '10','xp' => '0','gold' => '0','price' => '300', 'classes' => 'boots'],
                ['id' => '4','src' => 'boots-3_3f33afb.png', 'offset' => '3' ,'type' => '0','character_id' => '0','hp' => '10','xp' => '5','gold' => '5','price' => '500', 'classes' => 'boots'],
                ['id' => '5','src' => 'armor-0_a6ab82e.png', 'offset' => '0' ,'type' => '1','character_id' => '0','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'armor'],
                ['id' => '6','src' => 'armor-1_97456.png', 'offset' => '1' ,'type' => '1','character_id' => '0','hp' => '10','xp' => '0','gold' => '0','price' => '300', 'classes' => 'armor'],
                ['id' => '7','src' => 'armor-2_0762db6a6a.png', 'offset' => '2' ,'type' => '1','character_id' => '0','hp' => '15','xp' => '5','gold' => '5','price' => '600', 'classes' => 'armor'],
                ['id' => '8','src' => 'armor-3_af890fb23.png', 'offset' => '3' ,'type' => '1','character_id' => '0','hp' => '20','xp' => '10','gold' => '10','price' => '900', 'classes' => 'armor'],
                ['id' => '9','src' => 'guantlets-0_97s4d56.png', 'offset' => '0' ,'type' => '2','character_id' => '0','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'gauntlet1'],
                ['id' => '10','src' => 'guantlets-1_12s78a.png', 'offset' => '1' ,'type' => '2','character_id' => '0','hp' => '0','xp' => '0','gold' => '5','price' => '150', 'classes' => 'gauntlet1'],
                ['id' => '11','src' => 'guantlets-2_dc78a578.png', 'offset' => '2' ,'type' => '2','character_id' => '0','hp' => '5','xp' => '5','gold' => '10','price' => '300', 'classes' => 'gauntlet1'],
                ['id' => '12','src' => 'guantlets-3_785a78f.png', 'offset' => '3' ,'type' => '2','character_id' => '0','hp' => '5','xp' => '5','gold' => '15','price' => '600', 'classes' => 'gauntlet1'],
                ['id' => '13','src' => 'helmet-0_97456.png', 'offset' => '0' ,'type' => '3','character_id' => '0','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'helmet'],
                ['id' => '14','src' => 'helmet-1_a6ab82e.png', 'offset' => '1' ,'type' => '3','character_id' => '0','hp' => '0','xp' => '5','gold' => '0','price' => '200', 'classes' => 'helmet'],
                ['id' => '15','src' => 'helmet-2_97s4d56.png', 'offset' => '2' ,'type' => '3','character_id' => '0','hp' => '5','xp' => '10','gold' => '5','price' => '400', 'classes' => 'helmet'],
                ['id' => '16','src' => 'helmet-3_f6a0823.png', 'offset' => '3' ,'type' => '3','character_id' => '0','hp' => '10','xp' => '15','gold' => '10','price' => '500', 'classes' => 'helmet'],
                ['id' => '17','src' => 'shield-0_0762db6a6a.png', 'offset' => '0' ,'type' => '4','character_id' => '0','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'shield'],
                ['id' => '18','src' => 'shield-1_dc78a578.png', 'offset' => '1' ,'type' => '4','character_id' => '0','hp' => '5','xp' => '0','gold' => '0','price' => '150', 'classes' => 'shield'],
                ['id' => '19','src' => 'shield-2_cf69ab23.png', 'offset' => '2' ,'type' => '4','character_id' => '0','hp' => '15','xp' => '0','gold' => '0','price' => '300', 'classes' => 'shield'],
                ['id' => '20','src' => 'shield-3_a6ab82e.png', 'offset' => '3' ,'type' => '4','character_id' => '0','hp' => '20','xp' => '10','gold' => '5','price' => '600', 'classes' => 'shield'],
                ['id' => '21','src' => 'sword-0_974536_char.png', 'offset' => '0' ,'type' => '5','character_id' => '0','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'sword'],
                ['id' => '22','src' => 'sword-1_3f33afb_char.png', 'offset' => '1' ,'type' => '5','character_id' => '0','hp' => '0','xp' => '5','gold' => '5','price' => '300', 'classes' => 'sword'],
                ['id' => '23','src' => 'sword-2_dc78a578_char.png', 'offset' => '2' ,'type' => '5','character_id' => '0','hp' => '0','xp' => '10','gold' => '10','price' => '600', 'classes' => 'sword'],
                ['id' => '24','src' => 'sword-3_a6abe82e_char.png', 'offset' => '3' ,'type' => '5','character_id' => '0','hp' => '5','xp' => '15','gold' => '15','price' => '900', 'classes' => 'sword'],
                ['id' => '25','src' => 'boots-archer-0_943837.png', 'offset' => '0' ,'type' => '0','character_id' => '1','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'boots'],
                ['id' => '26','src' => 'boots-archer-1_0098721.png', 'offset' => '1' ,'type' => '0','character_id' => '1','hp' => '5','xp' => '0','gold' => '0','price' => '200', 'classes' => 'boots'],
                ['id' => '27','src' => 'boots-archer-2_6673907.png', 'offset' => '2' ,'type' => '0','character_id' => '1','hp' => '5','xp' => '10','gold' => '5','price' => '400', 'classes' => 'boots'],
                ['id' => '28','src' => 'boots-archer-3_133928.png', 'offset' => '3' ,'type' => '0','character_id' => '1','hp' => '10','xp' => '20','gold' => '10','price' => '600', 'classes' => 'boots'],
                ['id' => '29','src' => 'armor-archer-0_921afe2.png', 'offset' => '0' ,'type' => '1','character_id' => '1','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'armor'],
                ['id' => '30','src' => 'armor-archer-1_aaf34e2d.png', 'offset' => '1' ,'type' => '1','character_id' => '1','hp' => '5','xp' => '0','gold' => '0','price' => '200', 'classes' => 'armor'],
                ['id' => '31','src' => 'armor-archer-2_feb4c503.png', 'offset' => '2' ,'type' => '1','character_id' => '1','hp' => '10','xp' => '15','gold' => '5','price' => '400', 'classes' => 'armor'],
                ['id' => '32','src' => 'armor-archer-3_9a8ddd64.png', 'offset' => '3' ,'type' => '1','character_id' => '1','hp' => '10','xp' => '20','gold' => '15','price' => '600', 'classes' => 'armor'],
                ['id' => '33','src' => 'helmet_archer_0-5ec62a.png', 'offset' => '0' ,'type' => '3','character_id' => '1','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'helmet'],
                ['id' => '34','src' => 'helmet_archer_1-eff623a.png', 'offset' => '1' ,'type' => '3','character_id' => '1','hp' => '0','xp' => '10','gold' => '0','price' => '400', 'classes' => 'helmet'],
                ['id' => '35','src' => 'helmet_archer_2-555afc3.png', 'offset' => '2' ,'type' => '3','character_id' => '1','hp' => '5','xp' => '10','gold' => '5','price' => '800', 'classes' => 'helmet'],
                ['id' => '36','src' => 'helmet_archer_3-fa98340abc.png', 'offset' => '3' ,'type' => '3','character_id' => '1','hp' => '10','xp' => '20','gold' => '10','price' => '1000', 'classes' => 'helmet'],
                ['id' => '37','src' => 'bow-0_ffb467.png', 'offset' => '0','type' => '5','character_id' => '1','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'bow'],
                ['id' => '38','src' => 'bow-1_05fc4dd3.png', 'offset' => '1' ,'type' => '5','character_id' => '1','hp' => '0','xp' => '15','gold' => '5','price' => '700', 'classes' => 'bow'],
                ['id' => '39','src' => 'bow-2_fcafb.png', 'offset' => '2' ,'type' => '5','character_id' => '1','hp' => '5','xp' => '15','gold' => '10','price' => '1400', 'classes' => 'bow'],
                ['id' => '40','src' => 'bow-3_34abc56.png', 'offset' => '3' ,'type' => '5','character_id' => '1','hp' => '10','xp' => '20','gold' => '15','price' => '2000', 'classes' => 'bow'],
                ['id' => '41','src' => 'archer_gauntlets.png', 'offset' => '0' ,'type' => '2','character_id' => '1','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'gauntlet2'],
                ['id' => '42','src' => 'boots-mage-0_92084afc.png', 'offset' => '0' ,'type' => '0','character_id' => '2','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'boots'],
                ['id' => '43','src' => 'boots-mage-1_a2f4c3.png', 'offset' => '1' ,'type' => '0','character_id' => '2','hp' => '5','xp' => '0','gold' => '0','price' => '200', 'classes' => 'boots'],
                ['id' => '44','src' => 'boots-mage-2_ffcac4.png', 'offset' => '2' ,'type' => '0','character_id' => '2','hp' => '5','xp' => '0','gold' => '10','price' => '400', 'classes' => 'boots'],
                ['id' => '45','src' => 'boots-mage-4_0765ba2.png', 'offset' => '3' ,'type' => '0','character_id' => '2','hp' => '10','xp' => '10','gold' => '20','price' => '600', 'classes' => 'boots'],
                ['id' => '46','src' => 'armor-mage-0_88623.png', 'offset' => '0' ,'type' => '1','character_id' => '2','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'armor'],
                ['id' => '47','src' => 'armor-mage-1_76ab3c3.png', 'offset' => '1' ,'type' => '1','character_id' => '2','hp' => '0','xp' => '0','gold' => '10','price' => '400', 'classes' => 'armor'],
                ['id' => '48','src' => 'armor-mage-2_998abe3.png', 'offset' => '2' ,'type' => '1','character_id' => '2','hp' => '5','xp' => '5','gold' => '15','price' => '400', 'classes' => 'armor'],
                ['id' => '49','src' => 'armor-mage-3_ffc43.png', 'offset' => '3' ,'type' => '1','character_id' => '2','hp' => '10','xp' => '15','gold' => '20','price' => '600', 'classes' => 'armor'],
                ['id' => '50','src' => 'mage_guantlets.png', 'offset' => '0' ,'type' => '2','character_id' => '2','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'gauntlet2'],
                ['id' => '51','src' => 'helmet-mage-0_23453465.png', 'offset' => '0' ,'type' => '3','character_id' => '2','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'helmet helmet-mage'],
                ['id' => '52','src' => 'helmet-mage-1_abc7392.png', 'offset' => '1' ,'type' => '3','character_id' => '2','hp' => '0','xp' => '5','gold' => '0','price' => '200', 'classes' => 'helmet helmet-mage'],
                ['id' => '53','src' => 'helmet-mage-2_971bb2.png', 'offset' => '2' ,'type' => '3','character_id' => '2','hp' => '10','xp' => '10','gold' => '10','price' => '800', 'classes' => 'helmet helmet-mage'],
                ['id' => '54','src' => 'helmet-mage-3_ab673.png', 'offset' => '3' ,'type' => '3','character_id' => '2','hp' => '10','xp' => '10','gold' => '20','price' => '1000', 'classes' => 'helmet helmet-mage'],
                ['id' => '55','src' => 'staff-0_9827.png', 'offset' => '0' ,'type' => '5','character_id' => '2','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'staff'],
                ['id' => '56','src' => 'staff-1_abcfff.png', 'offset' => '1' ,'type' => '5','character_id' => '2','hp' => '5','xp' => '0','gold' => '15','price' => '700', 'classes' => 'staff'],
                ['id' => '57','src' => 'staff-2_ffa67dca.png', 'offset' => '2' ,'type' => '5','character_id' => '2','hp' => '5','xp' => '10','gold' => '15','price' => '1400', 'classes' => 'staff'],
                ['id' => '58','src' => 'staff-3_43d2cfe.png', 'offset' => '3' ,'type' => '5','character_id' => '2','hp' => '10','xp' => '15','gold' => '20','price' => '2000', 'classes' => 'staff'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_items');
    }
}
