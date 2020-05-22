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
