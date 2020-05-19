<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBehavioursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behaviours', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 50);
            $table->string('name', 200);
            $table->string('custom_text', 255);
            $table->smallInteger('hp')->default(0);
            $table->smallInteger('xp')->default(0);
            $table->smallInteger('gold')->default(0);
            $table->unsignedBigInteger('classroom_id')->nullable();
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
        Schema::dropIfExists('behaviours');
    }
}
