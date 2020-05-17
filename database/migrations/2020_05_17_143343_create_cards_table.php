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
             $table->string('src');
             $table->string('title', 40);
             $table->string('description');
             $table->tinyInteger('min_lvl')->default(0);
             $table->tinyInteger('type');
             $table->boolean('special');
             $table->string('width', 10);
             $table->smallInteger('margin_top')->default(0);
             $table->smallInteger('margin_left')->default(0);
             $table->string('background', 7);
             $table->smallInteger('radius')->default(0);
             $table->smallInteger('xp')->default(0);
             $table->smallInteger('hp')->default(0);
             $table->smallInteger('gold')->default(0);
             $table->smallInteger('slot')->default(0);
             $table->smallInteger('fullscreen')->default(0);
             $table->smallInteger('type_bg')->default(0);
             $table->unsignedBigInteger('classroom_id')->nullable();
             $table->timestamps();
            });
            
               DB::table('cards')->insert([
                
                ['id' => '1','src' => '/img/cards/festa.png','title' => 'default_cards.party_title','description' => 'default_cards.party_description','min_lvl' => '0','type' => '1','special' => '0','width' => '240px','margin_top' => '10','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '2','src' => '/img/cards/trollface.gif','title' => 'Trollface','description' => '<div><br></div>Esta carta no tiene utilidad','min_lvl' => '0','type' => '1','special' => '0','width' => '240px','margin_top' => '-30','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '3','src' => '/img/cards/future.png','title' => 'VisiÃ³n de futuro','description' => 'El profesor avisarÃ¡ con antelaciÃ³n de la siguiente prueba de conquista.','min_lvl' => '0','type' => '1','special' => '0','width' => '160px','margin_top' => '15','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '4','src' => '/img/cards/facepalm.png','title' => 'Facepalm','description' => 'La mala suerte te invade ... Â¡Esta carta te lo recordarÃ¡ el siguiente turno!','min_lvl' => '0','type' => '1','special' => '0','width' => '220px','margin_top' => '-10','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '5','src' => '/img/cards/teleport.jpeg','title' => 'Teletransporte','description' => 'Hoy te puedes cambiar de sitio con un compaÃ±ero.','min_lvl' => '0','type' => '1','special' => '0','width' => '240px','margin_top' => '25','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '6','src' => '/img/cards/favor.png','title' => 'Trato de favor','description' => 'Puedes eliminar una carta y Ã©sta recuperando el oro perdido. Shhhh Â¡No lo digas a nadie!','min_lvl' => '0','type' => '1','special' => '1','width' => '180px','margin_top' => '0','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '7','src' => '/img/cards/btf.png','title' => 'Back to the future','description' => '<div><br></div><div>Deshaz una acciÃ³n en la que has perdido puntos</div>','min_lvl' => '0','type' => '2','special' => '0','width' => '240px','margin_top' => '45','background' => '#ffffff','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '8','src' => '/img/cards/loteria.png','title' => 'La loterÃ­a','description' => '<div>Te ha tocado la loterÃ­a! Pero en la Ã©poca medieval no habÃ­a tanto oro...</div>','min_lvl' => '0','type' => '2','special' => '1','width' => '240px','margin_top' => '30','background' => '#5a5a5a','radius' => '0','xp' => '0','gold' => '150','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '9','src' => '/img/cards/impostos.png','title' => 'Impuestos','description' => '<br><div>Toca pagar impuestos ... Â¡Nadie se escapa!</div>','min_lvl' => '0','type' => '2','special' => '1','width' => '240px','margin_top' => '5','background' => '#5a5a5a','radius' => '0','xp' => '0','gold' => '-100','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '10','src' => '/img/cards/late.png','title' => 'No volverÃ¡ a pasar','description' => '<br><div>Te permite entrar en clase llegando tarde</div>','min_lvl' => '0','type' => '2','special' => '0','width' => '100px','margin_top' => '20','background' => '#6f6f6f','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '11','src' => '/img/cards/lucky.png','title' => 'Repesca','description' => 'DespuÃ©s de haber perdido una ciudad, lanza un dado y si es mayor a 4, te permite conquistarla.','min_lvl' => '2','type' => '2','special' => '0','width' => '160px','margin_top' => '20','background' => '#182d17','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '12','src' => '/img/cards/workHard.png','title' => 'Working Hard','description' => 'Os habÃ©is pasado la noche estudiando, Â¡ganÃ¡is experiencia!','min_lvl' => '0','type' => '2','special' => '1','width' => '160px','margin_top' => '20','background' => '#182d17','radius' => '0','xp' => '50','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '13','src' => '/img/cards/divina.png','title' => 'Ayuda divina','description' => 'El profesor te darÃ¡ una pista muy valiosa para resolver un problema.','min_lvl' => '4','type' => '2','special' => '0','width' => '200px','margin_top' => '20','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '14','src' => '/img/cards/help.png','title' => 'SituaciÃ³n complicada','description' => '<div><br></div><div>Pide ayuda a otro equipo.</div>','min_lvl' => '4','type' => '2','special' => '0','width' => '200px','margin_top' => '25','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '15','src' => '/img/cards/hospital.png','title' => 'Sanatorio','description' => '<div><br></div><div>Recupera HP a todo el grupo.</div>','min_lvl' => '4','type' => '2','special' => '0','width' => '200px','margin_top' => '25','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '20','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '16','src' => '/img/cards/hospital.png','title' => 'Sanatorio legendario','description' => '<div><br></div><div>Recupera HP a todo el grupo.</div>','min_lvl' => '4','type' => '3','special' => '0','width' => '200px','margin_top' => '25','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '40','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '17','src' => '/img/cards/all.png','title' => 'El ajo repetidor','description' => '<div><span style="font-size: 0.95em;">Los puntos de una conquista se multiplican por dos.</span><br></div>','min_lvl' => '5','type' => '2','special' => '0','width' => '160px','margin_top' => '10','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '18','src' => '/img/cards/cards.png','title' => 'Maestro de la baraja','description' => '<div><span style="font-size: 0.95em;"><br></span></div><div><span style="font-size: 0.95em;">Permite tener una carta mÃ¡s.</span><br></div>','min_lvl' => '0','type' => '2','special' => '1','width' => '220px','margin_top' => '-60','background' => '#4c0000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '1','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '19','src' => '/img/cards/joy.png','title' => 'SituaciÃ³n excepcional','description' => '<div><span style="font-size: 0.95em;">Mereceis un descanso! Toda la clase tiene 15 minutos de tiempo libre.</span><br></div>','min_lvl' => '4','type' => '3','special' => '0','width' => '200px','margin_top' => '0','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '20','src' => '/img/cards/hands.png','title' => 'InvitaciÃ³n oficial','description' => '<div><span style="font-size: 0.95em;">Ofrece a otro equipo compartir una ciudad que has conquistado (sin bonus de dinero y xp)</span><br></div>','min_lvl' => '4','type' => '3','special' => '0','width' => '200px','margin_top' => '15','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '21','src' => '/img/cards/pickle.gif','title' => 'By the face','description' => '<div><br></div><div><span style="font-size: 12.635px;">Gana experiencia y oro por la cara!</span></div>','min_lvl' => '4','type' => '3','special' => '0','width' => '120px','margin_top' => '25','background' => '#ffffff','radius' => '0','xp' => '25','gold' => '400','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '22','src' => '/img/cards/scater.png','title' => 'Aceptamos pulpo','description' => '<div>Os permite sugerir la creaciÃ³n de una carta. Tiene que ser aprobada por el profesor.</div>','min_lvl' => '4','type' => '3','special' => '0','width' => '180px','margin_top' => '10','background' => '#b90000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '23','src' => '/img/cards/cities.png','title' => 'Intercambio','description' => 'Intercambia una ciudad de tu posesiÃ³n por otra que no has podido conquistar.','min_lvl' => '5','type' => '3','special' => '0','width' => '240px','margin_top' => '0','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '24','src' => '/img/cards/happytroll_2.png','title' => 'EmpujÃ³n lengendario','description' => '<div><br></div>Aumenta 0.5 la nota de una prueba.','min_lvl' => '8','type' => '4','special' => '0','width' => '220px','margin_top' => '0','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '25','src' => '/img/cards/happytroll.png','title' => 'EmpujÃ³n Ã©pico','description' => '<div><br></div>Agmenta 0.25 la nota de una prueba.','min_lvl' => '6','type' => '3','special' => '0','width' => '220px','margin_top' => '5','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '26','src' => '/img/cards/countdown.png','title' => 'Final Countdown','description' => '<div><br></div>Te permite entregar 24 horas mÃ¡s tarde un ejercicio.','min_lvl' => '6','type' => '3','special' => '0','width' => '220px','margin_top' => '15','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '27','src' => '/img/cards/card_bg.png','title' => 'Conquista','description' => '<div><br></div>Te permite conquistar una ciudad de cualquier regiÃ³n.','min_lvl' => '5','type' => '4','special' => '0','width' => '200px','margin_top' => '20','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '28','src' => '/img/cards/zombie.png','title' => 'The walking dead','description' => '<div><br></div>Quan llegues a 0 de HP, recuperas 20 instantÃ¡neamente.','min_lvl' => '5','type' => '4','special' => '1','width' => '180px','margin_top' => '-35','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
                ['id' => '29','src' => '/img/cards/f5.gif','title' => 'El primero de la clase','description' => '<div><span style="font-size: 0.95em;">Eres el mÃ¡s rÃ¡pido! ComenzÃ¡is la prueba 5 minutos antes que los compaÃ±eros.&nbsp;</span><br></div>','min_lvl' => '3','type' => '3','special' => '0','width' => '240px','margin_top' => '-10','background' => '#000000','radius' => '0','xp' => '0','gold' => '0','hp' => '0','slot' => '0','margin_left' => '0','classroom_id' => NULL,'fullscreen' => '0','type_bg' => '0'],
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
