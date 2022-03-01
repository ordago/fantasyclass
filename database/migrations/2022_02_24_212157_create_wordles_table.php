<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wordles', function (Blueprint $table) {
            $table->id();
            $table->integer("xp");
            $table->integer("gold");
            $table->unsignedBigInteger("classroom_id");
            $table->boolean("played")->default(0);
            $table->smallInteger("type")->default(0);
            // 0 es, 1 ca, 2 en
            $table->smallInteger("dictionary")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wordles');
    }
}
