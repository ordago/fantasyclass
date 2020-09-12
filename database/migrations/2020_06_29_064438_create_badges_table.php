<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('type')->default(0);
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->integer('hp')->default(0);
            $table->integer('xp')->default(0);
            $table->integer('gold')->default(0);
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
        Schema::dropIfExists('badges');
    }
}
