<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddEvaluableIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rubric_row_student', function ($table) {
            $table->unsignedBigInteger('evaluable_id')->nullable()->after('rubric_row_item_id');
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
