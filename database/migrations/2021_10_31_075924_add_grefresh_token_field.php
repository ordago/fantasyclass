<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrefreshTokenField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('g_refresh_token')->nullable()->after('token');
            $table->string('g_token')->after('g_refresh_token')->nullable();
            $table->integer('g_expires_in')->after('g_token')->nullable();
            $table->string('g_folder')->after('g_expires_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('g_refresh_token');
            $table->dropColumn('g_token');
            $table->dropColumn('g_expires_in');
            $table->dropColumn('g_folder');
        });
    }
}
