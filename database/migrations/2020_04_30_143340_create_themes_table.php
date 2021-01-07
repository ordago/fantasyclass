<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('color', 7);
            $table->smallInteger('type');
            $table->timestamps();
        });

        DB::table('themes')->insert(
            [ 
                [ 'id' => '1','name' => 'color0.png','color' => '#8989ba','type' => '1' ],
                [ 'id' => '2','name' => 'color1.png','color' => '#dedede','type' => '1' ],
                [ 'id' => '3','name' => 'color2.png','color' => '#757575','type' => '1' ],
                [ 'id' => '4','name' => 'color3.png','color' => '#ef5350','type' => '1' ],
                [ 'id' => '5','name' => 'color4.png','color' => '#b61827','type' => '1' ],
                [ 'id' => '6','name' => 'color5.png','color' => '#e6ceff','type' => '1' ],
                [ 'id' => '7','name' => 'color6.png','color' => '#836fa9','type' => '1' ],
                [ 'id' => '8','name' => 'color7.png','color' => '#81d4fa','type' => '1' ],
                [ 'id' => '9','name' => 'color8.png','color' => '#4ba3c7','type' => '1' ],
                [ 'id' => '10','name' => 'color9.png','color' => '#aed581','type' => '1' ],
                [ 'id' => '11','name' => 'color10.png','color' => '#387002','type' => '1' ],
                [ 'id' => '12','name' => 'color11.png','color' => '#fff59d','type' => '1' ],
                [ 'id' => '13','name' => 'color12.png','color' => '#c6a700','type' => '1' ],
                [ 'id' => '14','name' => 'color13.png','color' => '#ffb74d','type' => '1' ],
                [ 'id' => '15','name' => 'color14.png','color' => '#fb8c00','type' => '1' ],
                [ 'id' => '16','name' => 'color15.png','color' => '#ff8a65','type' => '1' ],
                [ 'id' => '17','name' => 'color16.png','color' => '#ac0800','type' => '1' ],
                [ 'id' => '18','name' => 'mountains_at_sunset.svg','color' => '#fad7c1','type' => '1' ],
                [ 'id' => '19','name' => 'summer_mountains.svg','color' => '#baf4e5','type' => '1' ],
                [ 'id' => '20','name' => 'desert.svg','color' => '#f9e077','type' => '1' ],
                [ 'id' => '21','name' => 'forest.svg.png','color' => '#e3e8c8','type' => '1' ],
                [ 'id' => '22','name' => 'mountains.png','color' => '#b2d5d2','type' => '1' ],
                [ 'id' => '23','name' => 'landscape.svg','color' => '#a3e4e8','type' => '1' ],
                [ 'id' => '24','name' => 'island.svg','color' => '#91ccfe','type' => '1' ],
                [ 'id' => '25','name' => 'tropical.svg','color' => '#7cc1ea','type' => '1' ],
                [ 'id' => '26','name' => 'sunset.svg','color' => '#e73f64','type' => '1' ],
                [ 'id' => '27','name' => 'star_night.svg','color' => '#3e518e','type' => '1' ],
                [ 'id' => '28','name' => 'blue_night.svg','color' => '#587c9b','type' => '1' ],
                [ 'id' => '29','name' => 'winter.svg','color' => '#a9e1a1','type' => '1' ],
                [ 'id' => '30','name' => 'landscape_mountains.png','color' => '#3a68b7','type' => '1' ],
                [ 'id' => '31','name' => 'winter2.png','color' => '#4588d2','type' => '1' ],
                [ 'id' => '32','name' => 'desert2.svg','color' => '#bc5430','type' => '1' ],
                [ 'id' => '33','name' => 'night_bg.png','color' => '#000','type' => '1' ],
                [ 'id' => '34','name' => 'spring_bg.png','color' => '#9cdbd8','type' => '1' ],
                [ 'id' => '35','name' => 'winter3.png','color' => '#82b4e2','type' => '1' ],
                [ 'id' => '36','name' => 'winter_night.png','color' => '#292e44','type' => '1' ],
                [ 'id' => '37','name' => 'planet.png','color' => '#51a7ba','type' => '1' ],
                [ 'id' => '38','name' => 'mountains_only.png','color' => '#3a68b7','type' => '1' ],
                [ 'id' => '39','name' => 'forest.png','color' => '#000','type' => '1' ],
                [ 'id' => '40','name' => 'sundown.png','color' => '#74d1f3','type' => '1' ],
                [ 'id' => '41','name' => 'tropical.png','color' => '#da736b','type' => '1' ],
                [ 'id' => '42','name' => 'mars.png','color' => '#fda665','type' => '1' ],
                [ 'id' => '43','name' => 'mars2.png','color' => '#fec19e','type' => '1' ],
                [ 'id' => '44','name' => 'space.png','color' => '#fa755f','type' => '1' ],
                [ 'id' => '45','name' => 'mars3.png','color' => '#301c22','type' => '1' ],
                [ 'id' => '46','name' => 'winter4.png','color' => '#a3d2dc','type' => '1' ],
                [ 'id' => '47','name' => 'winter5.png','color' => '#6bcfc1','type' => '1' ],
                [ 'id' => '48','name' => 'night_purple.png','color' => '#7a5199','type' => '1' ],
                [ 'id' => '49','name' => 'colorful.png','color' => '#e7ad8e','type' => '1' ],
                [ 'id' => '50','name' => 'night_purple2.png','color' => '#2a2135','type' => '1' ],
                [ 'id' => '51','name' => 'night_starry.png','color' => '#34489f','type' => '1' ],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
