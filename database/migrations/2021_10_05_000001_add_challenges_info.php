<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddChallengesInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenge_student', function ($table) {
            $table->tinyInteger('evaluated')->default(1)->after('count');
        });
        Schema::table('challenge_group', function ($table) {
            $table->tinyInteger('evaluated')->default(1)->after('count');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challenge_student', function ($table) {
            $table->dropColumn('evaluated');
        });
        Schema::table('challenge_group', function ($table) {
            $table->dropColumn('evaluated');
        });

    }
}
