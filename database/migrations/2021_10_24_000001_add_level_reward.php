<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddLevelReward extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('levels', function ($table) {
            $table->double('gold')->default(0)->after('description');
            $table->unsignedBigInteger('card')->nullable()->after('description');
            $table->unsignedBigInteger('badge')->nullable()->after('description');
            $table->unsignedBigInteger('item')->nullable()->after('description');
            $table->unsignedBigInteger('pet')->nullable()->after('description');
            $table->unsignedBigInteger('collectible')->nullable()->after('description');
        });
        Schema::table('students', function ($table) {
            $table->integer('max_level')->default(0)->after('name');
        });
     

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('levels', function ($table) {
            $table->dropColumn('gold');
            $table->dropColumn('card');
            $table->dropColumn('badge');
            $table->dropColumn('item');
            $table->dropColumn('pet');
            $table->dropColumn('collectible');
        });
        Schema::table('students', function ($table) {
            $table->dropColumn('max_level');
        });

    }
}
