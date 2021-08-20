<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFoodChar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('character_themes')->insert(
            [
                ['id' => '10', 'name' => 'Food', 'classes' => NULL],
            ]
        );
        DB::table('characters')->insert(
            [
                ['id' => '33', 'name' => 'carrot', 'character_theme_id' => '10', 'property' => '', 'classes' => 'carrot'],
                ['id' => '34', 'name' => 'orange', 'character_theme_id' => '10', 'property' => '', 'classes' => 'orange'],
                ['id' => '35', 'name' => 'strawberry', 'character_theme_id' => '10', 'property' => '', 'classes' => 'strawberry'],
                ['id' => '36', 'name' => 'corn', 'character_theme_id' => '10', 'property' => '', 'classes' => 'corn'],
                ['id' => '37', 'name' => 'egg', 'character_theme_id' => '10', 'property' => '', 'classes' => 'egg'],
            ]
        );

        DB::table('equipment')->insert(
            [
                ['id' => '640', 'src' => 'food/carrot.png', 'offset' => '0', 'type' => '0', 'character_id' => '[33]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '641', 'src' => 'food/orange.png', 'offset' => '0', 'type' => '0', 'character_id' => '[34]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '642', 'src' => 'food/strawberry.png', 'offset' => '0', 'type' => '0', 'character_id' => '[35]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '643', 'src' => 'food/corn.png', 'offset' => '0', 'type' => '0', 'character_id' => '[36]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '644', 'src' => 'food/egg.png', 'offset' => '0', 'type' => '0', 'character_id' => '[37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '645', 'src' => 'food/food-arms.png', 'offset' => '0', 'type' => '1', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-arms'],
                ['id' => '646', 'src' => 'food/food-legs.png', 'offset' => '0', 'type' => '2', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-legs'],
                
                ['id' => '647', 'src' => 'food/happy_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '648', 'src' => 'food/happy_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '649', 'src' => 'food/happy_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '650', 'src' => 'food/happy_4.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '651', 'src' => 'food/angry_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '652', 'src' => 'food/angry_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '653', 'src' => 'food/angry_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '654', 'src' => 'food/crazy_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '655', 'src' => 'food/crazy_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '656', 'src' => 'food/crazy_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '657', 'src' => 'food/heart_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '658', 'src' => 'food/mask_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '659', 'src' => 'food/surprised_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '660', 'src' => 'food/upset_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '661', 'src' => 'food/upset_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '662', 'src' => 'food/upset_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '663', 'src' => 'food/yummy_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],

            ]
        );
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
