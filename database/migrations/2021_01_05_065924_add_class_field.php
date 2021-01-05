<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('character_themes', function (Blueprint $table) {
            $table->string('classes')->nullable()->default('character-small')->after('name');
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->string('classes')->nullable()->after('name');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
