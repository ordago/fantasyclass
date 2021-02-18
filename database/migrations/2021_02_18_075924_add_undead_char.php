<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddUndeadChar extends Migration
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
                ['id' => '8', 'name' => 'Undead', 'classes' => NULL],
            ]
        );
        DB::table('characters')->insert(
            [
                ['id' => '26', 'name' => 'Undead', 'character_theme_id' => '8', 'property' => '', 'classes' => NULL],
            ]
        );

        DB::table('equipment')->insert(
            [
                
                ['id' => '510', 'src' => 'fantasy/skeleton_head.png', 'offset' => '0', 'type' => '0', 'character_id' => '26', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'skeleton-head'],
                ['id' => '511', 'src' => 'fantasy/skeleton_arms.png', 'offset' => '0', 'type' => '1', 'character_id' => '26', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'skeleton-arms'],
                ['id' => '512', 'src' => 'fantasy/skeleton_body.png', 'offset' => '0', 'type' => '2', 'character_id' => '26', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'skeleton-body'],
                ['id' => '513', 'src' => 'fantasy/skeleton_legs.png', 'offset' => '0', 'type' => '3', 'character_id' => '26', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'skeleton-legs'],

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
