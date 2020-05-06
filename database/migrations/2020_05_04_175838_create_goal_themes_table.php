<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('goal_themes', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 100);
            $table->string('color', 7)->nullable();
            $table->timestamps();
        });

        DB::table('goal_themes')->insert(
            [ 
                ['id' => '1','icon' => 'fab fa-fort-awesome','color' => NULL],
                ['id' => '2','icon' => 'fas fa-treasure-chest','color' => '#c2a983'],
                ['id' => '3','icon' => 'fas fa-dragon','color' => '#acb493'],
                ['id' => '4','icon' => 'fas fa-bat','color' => '#98877f'],
                ['id' => '5','icon' => 'fas fa-dungeon','color' => NULL],
                ['id' => '6','icon' => 'fas fa-gopuram','color' => '#e7ad55'],
                ['id' => '7','icon' => 'fas fa-book','color' => '#5f9ea7'],
                ['id' => '8','icon' => 'fas fa-egg','color' => '#d58e52'],
                ['id' => '9','icon' => 'fas fa-flag-alt','color' => '#e9513d'],
                ['id' => '10','icon' => 'fas fa-chess-queen','color' => '#d9d5be'],
                ['id' => '11','icon' => 'fas fa-bowling-ball','color' => '#e18c2a'],
                ['id' => '12','icon' => 'fas fa-trees','color' => '#7da44b'],
                ['id' => '13','icon' => 'fas fa-map-marked-alt','color' => NULL],
                ['id' => '14','icon' => 'fas fa-chess-rook','color' => '#a7aea3'],
                ['id' => '15','icon' => 'fas fa-robot','color' => '#72c0d7'],
                ['id' => '16','icon' => 'fas fa-hat-witch','color' => '#8b47cb'],
                ['id' => '17','icon' => 'fas fa-ghost','color' => '#ec8027'],
                ['id' => '18','icon' => 'fas fa-broom','color' => '#c19b48'],
                ['id' => '19','icon' => 'fas fa-spider','color' => '#9d7256'],
                ['id' => '20','icon' => 'fas fa-landmark','color' => '#a7aea3'],
                ['id' => '21','icon' => 'fas fa-gem','color' => NULL],
                ['id' => '22','icon' => 'fas fa-helmet-battle','color' => '#a7aea3'],
                ['id' => '23','icon' => 'fas fa-ring','color' => '#f2de89'],
                ['id' => '24','icon' => 'fas fa-scroll-old','color' => '#f2e6cc'],
                ['id' => '25','icon' => 'fas fa-eye-evil','color' => '#e13f27'],
                ['id' => '26','icon' => 'fas fa-hood-cloak','color' => '#858594'],
                ['id' => '27','icon' => 'fas fa-user-secret','color' => '#acacac'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goal_themes');
    }
}
