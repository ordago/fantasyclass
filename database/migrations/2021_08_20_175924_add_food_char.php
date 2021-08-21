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
                ['id' => '38', 'name' => 'apple', 'character_theme_id' => '10', 'property' => '', 'classes' => 'apple'],
                ['id' => '39', 'name' => 'cherry', 'character_theme_id' => '10', 'property' => '', 'classes' => 'cherry'],
                ['id' => '40', 'name' => 'lemon', 'character_theme_id' => '10', 'property' => '', 'classes' => 'lemon'],
                ['id' => '41', 'name' => 'pepper', 'character_theme_id' => '10', 'property' => '', 'classes' => 'pepper'],
                ['id' => '42', 'name' => 'turnip', 'character_theme_id' => '10', 'property' => '', 'classes' => 'turnip'],

            ]
        );

        DB::table('equipment')->insert(
            [
                ['id' => '640', 'src' => 'food/carrot.png', 'offset' => '0', 'type' => '0', 'character_id' => '[33]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '641', 'src' => 'food/orange.png', 'offset' => '0', 'type' => '0', 'character_id' => '[34]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '642', 'src' => 'food/strawberry.png', 'offset' => '0', 'type' => '0', 'character_id' => '[35]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '643', 'src' => 'food/corn.png', 'offset' => '0', 'type' => '0', 'character_id' => '[36]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '644', 'src' => 'food/egg.png', 'offset' => '0', 'type' => '0', 'character_id' => '[37]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '645', 'src' => 'food/apple.png', 'offset' => '0', 'type' => '0', 'character_id' => '[38]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '646', 'src' => 'food/cherry.png', 'offset' => '0', 'type' => '0', 'character_id' => '[39]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '647', 'src' => 'food/lemon.png', 'offset' => '0', 'type' => '0', 'character_id' => '[40]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '648', 'src' => 'food/pepper.png', 'offset' => '0', 'type' => '0', 'character_id' => '[41]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                ['id' => '649', 'src' => 'food/turnip.png', 'offset' => '0', 'type' => '0', 'character_id' => '[42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-base'],
                
                ['id' => '658', 'src' => 'food/food-arms.png', 'offset' => '0', 'type' => '1', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-arms'],
                ['id' => '659', 'src' => 'food/food-legs.png', 'offset' => '0', 'type' => '2', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-legs'],
                
                ['id' => '660', 'src' => 'food/happy_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '661', 'src' => 'food/happy_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '662', 'src' => 'food/happy_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '663', 'src' => 'food/happy_4.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '664', 'src' => 'food/angry_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '665', 'src' => 'food/angry_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '666', 'src' => 'food/angry_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '667', 'src' => 'food/crazy_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '668', 'src' => 'food/crazy_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '669', 'src' => 'food/crazy_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '670', 'src' => 'food/heart_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '671', 'src' => 'food/mask_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '672', 'src' => 'food/surprised_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '673', 'src' => 'food/upset_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '674', 'src' => 'food/upset_2.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '675', 'src' => 'food/upset_3.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],
                ['id' => '676', 'src' => 'food/yummy_1.png', 'offset' => '0', 'type' => '3', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-face'],

                ['id' => '680', 'src' => 'food/food_left_0.png', 'offset' => '0', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-left'],
                ['id' => '681', 'src' => 'food/food_left_1_xp.png', 'offset' => '1', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '200', 'classes' => 'food-left'],
                ['id' => '682', 'src' => 'food/food_left_1_gold.png', 'offset' => '1', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '200', 'classes' => 'food-left'],
                ['id' => '683', 'src' => 'food/food_left_1_hp.png', 'offset' => '1', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'food-left'],
                ['id' => '684', 'src' => 'food/food_left_2_xp.png', 'offset' => '2', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '10', 'gold' => '10', 'price' => '400', 'classes' => 'food-left'],
                ['id' => '685', 'src' => 'food/food_left_2_gold.png', 'offset' => '2', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '10', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'food-left'],
                ['id' => '686', 'src' => 'food/food_left_2_hp.png', 'offset' => '2', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '10', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'food-left'],
                ['id' => '687', 'src' => 'food/food_left_3_xp.png', 'offset' => '3', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '15', 'gold' => '15', 'price' => '400', 'classes' => 'food-left'],
                ['id' => '688', 'src' => 'food/food_left_3_gold.png', 'offset' => '3', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '400', 'classes' => 'food-left'],
                ['id' => '689', 'src' => 'food/food_left_3_hp.png', 'offset' => '3', 'type' => '4', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '15', 'xp' => '15', 'gold' => '0', 'price' => '400', 'classes' => 'food-left'],
        
                ['id' => '690', 'src' => 'food/food_right_0.png', 'offset' => '0', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-right'],
                ['id' => '691', 'src' => 'food/food_right_1_xp.png', 'offset' => '1', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '200', 'classes' => 'food-right'],
                ['id' => '692', 'src' => 'food/food_right_1_gold.png', 'offset' => '1', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '200', 'classes' => 'food-right'],
                ['id' => '693', 'src' => 'food/food_right_1_hp.png', 'offset' => '1', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'food-right'],
                ['id' => '694', 'src' => 'food/food_right_2_xp.png', 'offset' => '2', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '10', 'gold' => '10', 'price' => '400', 'classes' => 'food-right'],
                ['id' => '695', 'src' => 'food/food_right_2_gold.png', 'offset' => '2', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '10', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'food-right'],
                ['id' => '696', 'src' => 'food/food_right_2_hp.png', 'offset' => '2', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '10', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'food-right'],
                ['id' => '697', 'src' => 'food/food_right_3_xp.png', 'offset' => '3', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '15', 'gold' => '15', 'price' => '400', 'classes' => 'food-right'],
                ['id' => '698', 'src' => 'food/food_right_3_gold.png', 'offset' => '3', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '400', 'classes' => 'food-right'],
                ['id' => '699', 'src' => 'food/food_right_3_hp.png', 'offset' => '3', 'type' => '5', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '15', 'xp' => '15', 'gold' => '0', 'price' => '400', 'classes' => 'food-right'],
                
                ['id' => '700', 'src' => 'food/food_hat_0.png', 'offset' => '0', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'food-hat'],
                ['id' => '701', 'src' => 'food/food_hat_1_xp.png', 'offset' => '1', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '200', 'classes' => 'food-hat'],
                ['id' => '702', 'src' => 'food/food_hat_1_gold.png', 'offset' => '1', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '5', 'xp' => '0', 'gold' => '5', 'price' => '200', 'classes' => 'food-hat'],
                ['id' => '703', 'src' => 'food/food_hat_1_hp.png', 'offset' => '1', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '5', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'food-hat'],
                ['id' => '704', 'src' => 'food/food_hat_2_xp.png', 'offset' => '2', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '10', 'gold' => '10', 'price' => '400', 'classes' => 'food-hat'],
                ['id' => '705', 'src' => 'food/food_hat_2_gold.png', 'offset' => '2', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '10', 'xp' => '0', 'gold' => '10', 'price' => '400', 'classes' => 'food-hat'],
                ['id' => '706', 'src' => 'food/food_hat_2_hp.png', 'offset' => '2', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '10', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'food-hat'],
                ['id' => '707', 'src' => 'food/food_hat_3_xp.png', 'offset' => '3', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '0', 'xp' => '15', 'gold' => '15', 'price' => '400', 'classes' => 'food-hat'],
                ['id' => '708', 'src' => 'food/food_hat_3_gold.png', 'offset' => '3', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '400', 'classes' => 'food-hat'],
                ['id' => '709', 'src' => 'food/food_hat_3_hp.png', 'offset' => '3', 'type' => '6', 'character_id' => '[33, 34, 35, 36, 37, 38, 39, 40, 41, 42]', 'hp' => '15', 'xp' => '15', 'gold' => '0', 'price' => '400', 'classes' => 'food-hat'],

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
