<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddStudentIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rubric_row_student', function ($table) {
            $table->unsignedBigInteger('from_student_id')->nullable()->after('evaluable_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rubric_row_student', function ($table) {
            $table->dropColumn('from_student_id');
        });

    }
}
