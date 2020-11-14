<?php

use Illuminate\Database\Migrations\Migration;

class AddEvaluableGroupIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluables', function ($table) {
            $table->unsignedBigInteger('evaluables_group_id')->after('id');
        });

        Schema::table('tags', function ($table) {
            $table->unsignedBigInteger('evaluables_group_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluables', function ($table) {
            $table->dropColumn('evaluables_group_id');
        });

        Schema::table('tags', function ($table) {
            $table->dropColumn('evaluables_group_id');
        });
    }
}
