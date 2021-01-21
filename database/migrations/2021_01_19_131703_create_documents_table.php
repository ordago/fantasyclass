<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type');
            $table->string('url')->nullable();
            $table->float('size')->nullable();
            $table->string('type_document')->nullable();
            $table->text('text')->nullable();
            $table->unsignedBigInteger('document_category_id');
            $table->unsignedBigInteger('uploader');
            $table->integer('indentation')->default(0);
            $table->integer('order');
            $table->boolean('visible')->default(1);
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
        Schema::dropIfExists('documents');
    }
}
