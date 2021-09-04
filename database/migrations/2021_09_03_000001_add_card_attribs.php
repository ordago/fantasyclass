<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddCardAttribs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function ($table) {
            $table->boolean('disabled')->default(0)->after('own');
            $table->boolean('automatic')->default(0)->after('disabled');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards', function ($table) {
            $table->dropColumn('disabled');
            $table->dropColumn('automatic');
        });

    }
}
