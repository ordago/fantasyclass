<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddEvalStudentIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluable_student', function ($table) {
            $table->unsignedBigInteger('from_student_id')->nullable()->after('feedback');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluable_student', function ($table) {
            $table->dropColumn('from_student_id');
        });

    }
}
