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
            $table->string('md5', 32);
            $table->string('enrollment_code', 6);
            $table->unsignedBigInteger('user_id');
            $table->smallInteger('character_theme');
            $table->boolean('configured')->default(0);
            $table->boolean('finished')->default(0);
            $table->boolean('disabled')->default(0);
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
        Schema::dropIfExists('classrooms');
    }
}
