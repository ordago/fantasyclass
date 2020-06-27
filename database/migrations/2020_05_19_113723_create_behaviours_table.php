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
            $table->string('custom_text', 255)->nullable();
            $table->integer('hp')->default(0);
            $table->integer('xp')->default(0);
            $table->integer('gold')->default(0);
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->integer('count_number')->default(0);
            $table->timestamps();
        });

        DB::table('behaviours')->insert(
            [
                ['id' => '1', 'name' => 'behaviours.hp_participation', 'icon' => 'far fa-hand-point-up', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_participation', 'classroom_id' => NULL],
                ['id' => '2', 'name' => 'behaviours.hp_homework', 'icon' => 'fas fa-book-open', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_homework', 'classroom_id' => NULL],
                ['id' => '3', 'name' => 'behaviours.hp_behaviour', 'icon' => 'far fa-smile', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_behaviour', 'classroom_id' => NULL],
                ['id' => '4', 'name' => 'behaviours.hp_task_effort', 'icon' => 'far fa-hand-rock', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_task_effort', 'classroom_id' => NULL],
                ['id' => '5', 'name' => 'behaviours.hp_attendance', 'icon' => 'far fa-clock', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_attendance', 'classroom_id' => NULL],
                ['id' => '6', 'name' => 'behaviours.hp_team_work', 'icon' => 'fas fa-users', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_team_work', 'classroom_id' => NULL],
                ['id' => '7', 'name' => 'behaviours.hp_answer_ok', 'icon' => 'far fa-thumbs-up', 'hp' => '5', 'xp' => '20', 'gold' => '0', 'custom_text' => 'behaviours.hp_answer_ok', 'classroom_id' => NULL],
                ['id' => '10', 'name' => 'behaviours.hp_mobile', 'icon' => 'fas fa-mobile-alt', 'hp' => '-20', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_mobile', 'classroom_id' => NULL],
                ['id' => '11', 'name' => 'behaviours.hp_no_homework', 'icon' => 'fas fa-book-open', 'hp' => '-20', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_no_homework', 'classroom_id' => NULL],
                ['id' => '12', 'name' => 'behaviours.hp_bad_behaviour', 'icon' => 'far fa-angry', 'hp' => '-40', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_bad_behaviour', 'classroom_id' => NULL],
                ['id' => '13', 'name' => 'behaviours.hp_no_subject', 'icon' => 'fas fa-gamepad', 'hp' => '-20', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_no_subject', 'classroom_id' => NULL],
                ['id' => '14', 'name' => 'behaviours.hp_late', 'icon' => 'far fa-clock', 'hp' => '-5', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_late', 'classroom_id' => NULL],
                ['id' => '15', 'name' => 'behaviours.hp_attendance_down', 'icon' => 'far fa-calendar-alt', 'hp' => '-15', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_attendance_down', 'classroom_id' => NULL],
                ['id' => '16', 'name' => 'behaviours.hp_eating', 'icon' => 'fas fa-cookie-bite', 'hp' => '-30', 'xp' => '0', 'gold' => '0', 'custom_text' => 'behaviours.hp_eating', 'classroom_id' => NULL],
                ['id' => '17', 'name' => 'behaviours.hp_answer_ko', 'icon' => 'far fa-thumbs-down', 'hp' => '-5', 'xp' => '-10', 'gold' => '0', 'custom_text' => 'behaviours.hp_answer_ko', 'classroom_id' => NULL]
            ]
        );
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
