<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name', 40)->nullable();
            $table->float('hp')->default(100);
            $table->float('hp_boost');
            $table->float('xp_boost');
            $table->float('gold_boost');
            $table->float('price');
            $table->boolean('for_sale')->default(0);
            $table->unsignedBigInteger('classroom_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
