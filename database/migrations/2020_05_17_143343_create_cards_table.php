<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * */
     public function up()
     {
         Schema::create('cards', function (Blueprint $table) {
             $table->id();
             $table->string('src')->nullable();
             $table->string('title', 40)->nullable();
             $table->string('description')->nullable();
             $table->tinyInteger('min_lvl')->default(0);
             $table->tinyInteger('type')->default(1);
             $table->boolean('special')->default(false);
             $table->smallInteger('width');
             $table->smallInteger('margin_top')->default(0);
             $table->smallInteger('margin_left')->default(0);
             $table->string('background', 7);
             $table->smallInteger('radius')->default(0);
             $table->integer('xp')->default(0);
             $table->integer('hp')->default(0);
             $table->integer('gold')->default(0);
             $table->smallInteger('slot')->default(0);
             $table->smallInteger('fullscreen')->default(0);
             $table->smallInteger('type_bg')->default(0);
             $table->unsignedBigInteger('classroom_id')->nullable();
             $table->boolean('shared')->default(0);
             $table->timestamps();
            });
            
                DB::table('cards')->insert([
                
                ['id' => '1','src' => '/img/cards/festa.png','title' => 'cards.party_title','description' => 'cards.party_description','min_lvl' => '0','type' => '1','special' => '0','width' => '240','margin_top' => '10','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '2','src' => '/img/cards/trollface.gif','title' => 'Trollface','description' => 'cards.trollface_description','min_lvl' => '0','type' => '1','special' => '0','width' => '240','margin_top' => '-30','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '3','src' => '/img/cards/future.png','title' => 'cards.future_title','description' => 'cards.future_description','min_lvl' => '0','type' => '1','special' => '0','width' => '160','margin_top' => '15','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '40','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '4','src' => '/img/cards/facepalm.png','title' => 'Facepalm','description' => 'cards.facepalm_description','min_lvl' => '0','type' => '1','special' => '0','width' => '220','margin_top' => '-10', 'margin_left' => '10', 'background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '5','src' => '/img/cards/teleport.jpeg','title' => 'cards.teleport_title','description' => 'cards.teleport_description','min_lvl' => '0','type' => '1','special' => '0','width' => '250','margin_top' => '25','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '6','src' => '/img/cards/favor.png','title' => 'cards.favor_title','description' => 'cards.favor_description','min_lvl' => '0','type' => '1','special' => '1','width' => '180','margin_top' => '0','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '7','src' => '/img/cards/btf.png','title' => 'Back to the future','description' => 'cards.back_description','min_lvl' => '0','type' => '2','special' => '0','width' => '240','margin_top' => '45','background' => '#ffffff','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '8','src' => '/img/cards/loteria.png','title' => 'cards.lottery_title','description' => 'cards.lottery_description','min_lvl' => '0','type' => '2','special' => '1','width' => '240','margin_top' => '30','background' => '#5a5a5a','radius' => '0','xp' => '0','gold' => '150','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '9','src' => '/img/cards/impostos.png','title' => 'cards.taxes_title','description' => 'cards.taxes_description','min_lvl' => '0','type' => '2','special' => '1','width' => '240','margin_top' => '5','background' => '#5a5a5a','radius' => '0','xp' => '0','gold' => '-100','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '10','src' => '/img/cards/late.png','title' => 'cards.late_title','description' => 'cards.late_description','min_lvl' => '0','type' => '2','special' => '0','width' => '100','margin_top' => '20','background' => '#6f6f6f','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '65','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '11','src' => '/img/cards/lucky.png','title' => 'cards.second_title','description' => 'cards.second_description','min_lvl' => '2','type' => '2','special' => '0','width' => '160','margin_top' => '20','background' => '#182d17','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '40','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '12','src' => '/img/cards/workHard.png','title' => 'cards.working_title','description' => 'cards.working_description','min_lvl' => '0','type' => '2','special' => '1','width' => '160','margin_top' => '20','background' => '#182d17','radius' => '0','xp' => '50','gold' => '0','hp' => '0','slot' => '0','margin_left' => '40','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '13','src' => '/img/cards/divina.png','title' => 'cards.divine_title','description' => 'cards.divine_description','min_lvl' => '4','type' => '2','special' => '0','width' => '200','margin_top' => '20','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '20','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '14','src' => '/img/cards/help.png','title' => 'cards.complicated_title','description' => 'cards.complicated_description','min_lvl' => '4','type' => '2','special' => '0','width' => '200','margin_top' => '25','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '25','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '15','src' => '/img/cards/hospital.png','title' => 'cards.sanatorium_title','description' => 'cards.sanatorium_description','min_lvl' => '4','type' => '2','special' => '0','width' => '200','margin_top' => '25','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '20','slot' => '0','margin_left' => '25','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '16','src' => '/img/cards/hospital.png','title' => 'cards.sanatorium_legendary_title','description' => 'cards.sanatorium_legendary_description','min_lvl' => '4','type' => '3','special' => '0','width' => '200','margin_top' => '25','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '40','slot' => '0','margin_left' => '25','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '17','src' => '/img/cards/all.png','title' => 'cards.garlic_title','description' => 'cards.garlic_description','min_lvl' => '5','type' => '2','special' => '0','width' => '160','margin_top' => '10','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '40','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '18','src' => '/img/cards/cards.png','title' => 'cards.deck_title','description' => 'cards.deck_description','min_lvl' => '0','type' => '2','special' => '1','width' => '220','margin_top' => '-60','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '1','margin_left' => '15','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '19','src' => '/img/cards/joy.png','title' => 'cards.exceptional_title','description' => 'cards.exceptional_description','min_lvl' => '4','type' => '3','special' => '0','width' => '200','margin_top' => '0','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '25','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '20','src' => '/img/cards/hands.png','title' => 'cards.invitation_title','description' => 'cards.invitation_description','min_lvl' => '4','type' => '3','special' => '0','width' => '200','margin_top' => '15','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '25','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '21','src' => '/img/cards/pickle.gif','title' => 'cards.face_title','description' => 'cards.face_description','min_lvl' => '4','type' => '3','special' => '0','width' => '120','margin_top' => '25','background' => '#ffffff','radius' => '0','xp' => '25','gold' => '400','hp' => '0','slot' => '0','margin_left' => '62','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '22','src' => '/img/cards/scater.png','title' => 'cards.scatergories_title','description' => 'cards.scatergories_description','min_lvl' => '4','type' => '3','special' => '0','width' => '180','margin_top' => '10','background' => '#b90000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '35','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '24','src' => '/img/cards/happytroll_2.png','title' => 'cards.pushl_title','description' => 'cards.pushl_description','min_lvl' => '8','type' => '4','special' => '0','width' => '220','margin_top' => '0','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '25','src' => '/img/cards/happytroll.png','title' => 'cards.pushe_title','description' => 'cards.pushe_description','min_lvl' => '6','type' => '3','special' => '0','width' => '220','margin_top' => '5','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '26','src' => '/img/cards/countdown.png','title' => 'Final Countdown','description' => 'cards.countdown_description','min_lvl' => '6','type' => '3','special' => '0','width' => '220','margin_top' => '15','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '15','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '27','src' => '/img/cards/card_bg.png','title' => 'cards.conquer_title','description' => 'cards.conquer_description','min_lvl' => '5','type' => '4','special' => '0','width' => '200','margin_top' => '20','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '25','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '28','src' => '/img/cards/zombie.png','title' => 'The walking dead','description' => 'cards.walking_description','min_lvl' => '5','type' => '4','special' => '1','width' => '180','margin_top' => '-35','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '10','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '29','src' => '/img/cards/f5.gif','title' => 'cards.first_title','description' => 'cards.first_description','min_lvl' => '3','type' => '3','special' => '0','width' => '240','margin_top' => '-10','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
            ]);   
            
        }
        
        /**
         * Reverse the migrations.
         *
         * @return void
         * */
         public function down()
         {
             Schema::dropIfExists('cards');
            }
        }
