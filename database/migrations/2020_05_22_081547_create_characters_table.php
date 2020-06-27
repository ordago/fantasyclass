<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->unsignedBigInteger('character_theme_id');
            $table->string('property');
        });

        DB::table('characters')->insert(
            [ 
                ['id' => '1','name' => 'Warrior', 'character_theme_id' => '1', 'property' => 'fas fa-heart'],
                ['id' => '2','name' => 'Archer', 'character_theme_id' => '1', 'property' => 'fas fa-fist-raised'],
                ['id' => '3','name' => 'Wizard', 'character_theme_id' => '1', 'property' => 'fas fa-coins'],
                ['id' => '4','name' => 'Lightbot', 'character_theme_id' => '2', 'property' => 'fas fa-fist-raised'],
                ['id' => '5','name' => 'Anty', 'character_theme_id' => '2', 'property' => 'fas fa-heart'],
                ['id' => '6','name' => 'Driver', 'character_theme_id' => '2', 'property' => 'fas fa-coins'],
                ['id' => '7','name' => 'Superhero1', 'character_theme_id' => '3', 'property' => 'fas fa-coins'],
                ['id' => '8','name' => 'Superhero2', 'character_theme_id' => '3', 'property' => 'fas fa-heart'],
                ['id' => '9','name' => 'Superhero3', 'character_theme_id' => '3', 'property' => 'fas fa-fist-raised'],
                ['id' => '10','name' => 'Seal', 'character_theme_id' => '4', 'property' => 'fas fa-heart'],
                ['id' => '11','name' => 'Donkey', 'character_theme_id' => '4', 'property' => 'fas fa-coins'],
                ['id' => '12','name' => 'Castor', 'character_theme_id' => '4', 'property' => 'fas fa-fist-raised'],
                ['id' => '13','name' => 'Tiger', 'character_theme_id' => '4', 'property' => 'fas fa-heart'],
                ['id' => '14','name' => 'Croco', 'character_theme_id' => '4', 'property' => 'fas fa-coins'],
            ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
