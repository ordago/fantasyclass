<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->integer('hp')->default(0);
            $table->integer('xp')->default(0);
            $table->integer('gold')->default(0);
            $table->integer('price')->default(0);
            $table->boolean('for_sale')->default(0);
            $table->string('description')->nullable();
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->integer('min_lvl')->default(0);
            $table->timestamps();
        });

        DB::table('items')->insert(
            [
                ['id' => '1','icon' => '/img/shop/hp_big.png','hp' => '20','xp' => '0','gold' => '0','price' => '250','for_sale' => '1','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '2','icon' => '/img/shop/hp_medium.png','hp' => '10','xp' => '0','gold' => '0','price' => '150','for_sale' => '1','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '3','icon' => '/img/shop/blue.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '4', 'icon' => '/img/shop/candle.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '5','icon' => '/img/shop/diamond.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '6','icon' => '/img/shop/egg.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '7','icon' => '/img/shop/esmerald.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '8','icon' => '/img/shop/grail.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '9','icon' => '/img/shop/key1.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '10','icon' => '/img/shop/key2.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '11','icon' => '/img/shop/pergamin1.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '12','icon' => '/img/shop/pergamin2.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '13','icon' => '/img/shop/ring.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '14','icon' => '/img/shop/rubi.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '15','icon' => '/img/shop/table1.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
                ['id' => '16','icon' => '/img/shop/table2.png','hp' => '0','xp' => '0','gold' => '0','price' => '0','for_sale' => '0','description' => NULL,'classroom_id' => NULL,'min_lvl' => '0'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
