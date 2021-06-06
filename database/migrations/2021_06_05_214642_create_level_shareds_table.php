<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelSharedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_shareds', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('number');
            $table->integer('xp');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('level_group_id');
            $table->timestamps();

            $table->foreign('level_group_id')->references('id')->on('level_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_shareds');
    }
}
