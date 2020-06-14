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
            $table->unsignedBigInteger('challenges_group_id');
            // 0 -> individual; 1 -> group
            $table->tinyInteger('type')->default(0);
            $table->string('title');
            $table->string('description', 250)->nullable();
            $table->longText('content')->nullable();
            $table->dateTime('datetime');
            $table->string('icon', 100)->nullable();
            $table->string('color', 7)->nullable();
            $table->integer('xp')->default(0);
            $table->integer('hp')->default(0);
            $table->integer('gold')->default(0);
            $table->smallInteger('cards')->default(0);

            // 0 -> Teacher mark as done // 1 -> Studen mark as done // 2 -> Both mark as done
            $table->smallInteger('completion')->default(0);
            
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
