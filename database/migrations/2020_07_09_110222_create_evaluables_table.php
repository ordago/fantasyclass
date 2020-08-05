<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluables', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->smallInteger('type')->default(0);
            $table->unsignedBigInteger('rubric_id')->nullable();
            $table->unsignedBigInteger('challenge_id')->nullable()->unique();
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
        Schema::dropIfExists('evaluables');
    }
}
