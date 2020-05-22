<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
        });

        DB::table('character_themes')->insert(
            [ 
                ['id' => '1','name' => 'Fantasy'],
                ['id' => '2','name' => 'Robots'],
                ['id' => '3','name' => 'Superheros'],
                ['id' => '4','name' => 'Pirates / animals'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_themes');
    }
}
