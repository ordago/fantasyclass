<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('challenge_group_id');
            // 0 -> individual; 1 -> group
            $table->tinyInteger('type')->default(0);
            $table->string('title');
            $table->string('description', 250)->nullable();
            $table->longText('content')->nullable();
            $table->dateTime('datetime');
            $table->string('icon', 100)->nullable();
            $table->smallInteger('xp')->default(0);
            $table->smallInteger('hp')->default(0);
            $table->smallInteger('gold')->default(0);
            $table->smallInteger('cards')->default(0);
            // $table->json('items')->nullable();
            // $table->json('requirements_visibility')->nullable();
            // $table->json('requirements_success')->nullable();
            // $table->json('targets')->nullable();
            $table->boolean('is_conquer')->default(0);
            $table->boolean('auto_assign')->default(1);
            $table->boolean('optional')->default(0);
            $table->string('password')->nullable();
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
        Schema::dropIfExists('challenges');
    }
}
