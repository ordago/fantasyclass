<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('adventure_name', 255);
            $table->string('code', 32)->unique();
            $table->string('enrollment_code', 6);
            $table->smallInteger('character_theme');
            $table->unsignedBigInteger('goal_type');
            $table->unsignedBigInteger('theme_id');
            $table->timestamps();

            $table->foreign('theme_id')->references('id')->on('themes');
            $table->foreign('goal_type')->references('id')->on('goal_themes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
