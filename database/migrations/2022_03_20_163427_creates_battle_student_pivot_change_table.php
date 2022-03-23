<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesBattleStudentPivotChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battle_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('battle_id');
            $table->unsignedBigInteger('student_id');
            $table->json('state');
            // 1 for passed, 2 for failed, 0 in progress
            $table->smallInteger('passed')->default(0);
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
        Schema::dropIfExists('battle_student');
    }
}
