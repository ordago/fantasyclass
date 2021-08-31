<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionableSharedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collectionable_shareds', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('type')->default(1);
            $table->unsignedBigInteger('collection_group_id');
            $table->timestamps();

            $table->foreign('collection_group_id')->references('id')->on('collection_groups')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collectionable_shareds');
    }
}
