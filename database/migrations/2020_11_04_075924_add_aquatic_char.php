<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddAquaticChar extends Migration
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
                ['id' => '6', 'name' => 'Aquatic'],
            ]
        );
        DB::table('characters')->insert(
            [
                ['id' => '16', 'name' => 'Atlantis', 'character_theme_id' => '6', 'property' => 'fas fa-fist-raised'],
                ['id' => '17', 'name' => 'Desertores', 'character_theme_id' => '6', 'property' => 'fas fa-coins'],
                ['id' => '18', 'name' => 'Fosa', 'character_theme_id' => '6', 'property' => 'fas fa-heart'],
                ['id' => '19', 'name' => 'Mar Escondido', 'character_theme_id' => '6', 'property' => 'fas fa-coins'],
                ['id' => '20', 'name' => 'Pescadores', 'character_theme_id' => '6', 'property' => 'fas fa-heart'],
                ['id' => '21', 'name' => 'Salmuera', 'character_theme_id' => '6', 'property' => 'fas fa-fist-raised'],
                ['id' => '22', 'name' => 'Xebel', 'character_theme_id' => '6', 'property' => 'fas fa-fist-raised'],
            ]
        );

        DB::table('equipment')->insert(
            [
                ['id' => '310', 'src' => 'aquatic/atlantis-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '16', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots-atlantis'],
                ['id' => '311', 'src' => 'aquatic/atlantis-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '16', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'boots-atlantis'],
                ['id' => '312', 'src' => 'aquatic/atlantis-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '16', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '400', 'classes' => 'boots-atlantis'],
                ['id' => '313', 'src' => 'aquatic/atlantis-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '16', 'hp' => '20', 'xp' => '0', 'gold' => '0', 'price' => '600', 'classes' => 'boots-atlantis'],

                ['id' => '314', 'src' => 'aquatic/atlantis-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '16', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-right-atlantis'],
                ['id' => '315', 'src' => 'aquatic/atlantis-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '16', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-right-atlantis'],
                ['id' => '316', 'src' => 'aquatic/atlantis-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '16', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-right-atlantis'],
                ['id' => '317', 'src' => 'aquatic/atlantis-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '16', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-right-atlantis'],
                
                ['id' => '318', 'src' => 'aquatic/atlantis-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '16', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-left-atlantis'],
                ['id' => '319', 'src' => 'aquatic/atlantis-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '16', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-left-atlantis'],
                ['id' => '320', 'src' => 'aquatic/atlantis-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '16', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-left-atlantis'],
                ['id' => '321', 'src' => 'aquatic/atlantis-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '16', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-left-atlantis'],
                
                ['id' => '322', 'src' => 'aquatic/atlantis-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '16', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet-atlantis'],
                ['id' => '323', 'src' => 'aquatic/atlantis-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '16', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'helmet-atlantis'],
                ['id' => '324', 'src' => 'aquatic/atlantis-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '16', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'helmet-atlantis'],
                ['id' => '325', 'src' => 'aquatic/atlantis-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '16', 'hp' => '0', 'xp' => '30', 'gold' => '0', 'price' => '800', 'classes' => 'helmet-atlantis'],
                
                ['id' => '326', 'src' => 'aquatic/atlantis-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '16', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor-atlantis'],
                ['id' => '327', 'src' => 'aquatic/atlantis-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '16', 'hp' => '5', 'xp' => '5', 'gold' => '5', 'price' => '500', 'classes' => 'armor-atlantis'],
                ['id' => '328', 'src' => 'aquatic/atlantis-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '16', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '800', 'classes' => 'armor-atlantis'],
                ['id' => '329', 'src' => 'aquatic/atlantis-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '16', 'hp' => '40', 'xp' => '0', 'gold' => '40', 'price' => '1000', 'classes' => 'armor-atlantis'],
                
                ['id' => '330', 'src' => 'aquatic/desertor-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '17', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'boots-desertores'],
                ['id' => '331', 'src' => 'aquatic/desertor-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '17', 'hp' => '5', 'gold' => '0', 'xp' => '0', 'price' => '200', 'classes' => 'boots-desertores'],
                ['id' => '332', 'src' => 'aquatic/desertor-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '17', 'hp' => '10', 'gold' => '0', 'xp' => '0', 'price' => '400', 'classes' => 'boots-desertores'],
                ['id' => '333', 'src' => 'aquatic/desertor-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '17', 'hp' => '20', 'gold' => '0', 'xp' => '0', 'price' => '600', 'classes' => 'boots-desertores'],

                ['id' => '334', 'src' => 'aquatic/desertor-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '17', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-right-desertores'],
                ['id' => '335', 'src' => 'aquatic/desertor-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '17', 'hp' => '0', 'gold' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-right-desertores'],
                ['id' => '336', 'src' => 'aquatic/desertor-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '17', 'hp' => '0', 'gold' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-right-desertores'],
                ['id' => '337', 'src' => 'aquatic/desertor-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '17', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-right-desertores'],
                
                ['id' => '338', 'src' => 'aquatic/desertor-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '17', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-left-desertores'],
                ['id' => '339', 'src' => 'aquatic/desertor-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '17', 'hp' => '0', 'gold' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-left-desertores'],
                ['id' => '340', 'src' => 'aquatic/desertor-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '17', 'hp' => '0', 'gold' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-left-desertores'],
                ['id' => '341', 'src' => 'aquatic/desertor-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '17', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-left-desertores'],
                
                ['id' => '342', 'src' => 'aquatic/desertor-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '17', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'helmet-desertores'],
                ['id' => '343', 'src' => 'aquatic/desertor-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '17', 'hp' => '0', 'gold' => '5', 'xp' => '5', 'price' => '400', 'classes' => 'helmet-desertores'],
                ['id' => '344', 'src' => 'aquatic/desertor-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '17', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'helmet-desertores'],
                ['id' => '345', 'src' => 'aquatic/desertor-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '17', 'hp' => '0', 'gold' => '30', 'xp' => '0', 'price' => '800', 'classes' => 'helmet-desertores'],
                
                ['id' => '346', 'src' => 'aquatic/desertor-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '17', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'armor-desertores'],
                ['id' => '347', 'src' => 'aquatic/desertor-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '17', 'hp' => '5', 'gold' => '5', 'xp' => '5', 'price' => '500', 'classes' => 'armor-desertores'],
                ['id' => '348', 'src' => 'aquatic/desertor-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '17', 'hp' => '15', 'gold' => '0', 'xp' => '15', 'price' => '800', 'classes' => 'armor-desertores'],
                ['id' => '349', 'src' => 'aquatic/desertor-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '17', 'hp' => '40', 'gold' => '0', 'xp' => '40', 'price' => '1000', 'classes' => 'armor-desertores'],
                
                ['id' => '350', 'src' => 'aquatic/fosa-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '18', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'boots-fosa'],
                ['id' => '351', 'src' => 'aquatic/fosa-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '18', 'gold' => '5', 'hp' => '0', 'xp' => '0', 'price' => '200', 'classes' => 'boots-fosa'],
                ['id' => '352', 'src' => 'aquatic/fosa-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '18', 'gold' => '10', 'hp' => '0', 'xp' => '0', 'price' => '400', 'classes' => 'boots-fosa'],
                ['id' => '353', 'src' => 'aquatic/fosa-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '18', 'gold' => '20', 'hp' => '0', 'xp' => '0', 'price' => '600', 'classes' => 'boots-fosa'],

                ['id' => '354', 'src' => 'aquatic/fosa-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '18', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-right-fosa'],
                ['id' => '355', 'src' => 'aquatic/fosa-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '18', 'gold' => '0', 'hp' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-right-fosa'],
                ['id' => '356', 'src' => 'aquatic/fosa-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '18', 'gold' => '0', 'hp' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-right-fosa'],
                ['id' => '357', 'src' => 'aquatic/fosa-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '18', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-right-fosa'],
                
                ['id' => '358', 'src' => 'aquatic/fosa-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '18', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-left-fosa'],
                ['id' => '359', 'src' => 'aquatic/fosa-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '18', 'gold' => '0', 'hp' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-left-fosa'],
                ['id' => '360', 'src' => 'aquatic/fosa-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '18', 'gold' => '0', 'hp' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-left-fosa'],
                ['id' => '361', 'src' => 'aquatic/fosa-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '18', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-left-fosa'],
                
                ['id' => '362', 'src' => 'aquatic/fosa-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '18', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'helmet-fosa'],
                ['id' => '363', 'src' => 'aquatic/fosa-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '18', 'gold' => '0', 'hp' => '5', 'xp' => '5', 'price' => '400', 'classes' => 'helmet-fosa'],
                ['id' => '364', 'src' => 'aquatic/fosa-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '18', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'helmet-fosa'],
                ['id' => '365', 'src' => 'aquatic/fosa-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '18', 'gold' => '0', 'hp' => '30', 'xp' => '0', 'price' => '800', 'classes' => 'helmet-fosa'],
                
                ['id' => '366', 'src' => 'aquatic/fosa-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '18', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'armor-fosa'],
                ['id' => '367', 'src' => 'aquatic/fosa-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '18', 'gold' => '5', 'hp' => '5', 'xp' => '5', 'price' => '500', 'classes' => 'armor-fosa'],
                ['id' => '368', 'src' => 'aquatic/fosa-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '18', 'gold' => '15', 'hp' => '0', 'xp' => '15', 'price' => '800', 'classes' => 'armor-fosa'],
                ['id' => '369', 'src' => 'aquatic/fosa-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '18', 'gold' => '40', 'hp' => '0', 'xp' => '40', 'price' => '1000', 'classes' => 'armor-fosa'],
                
                ['id' => '370', 'src' => 'aquatic/mar-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '19', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'boots-mar'],
                ['id' => '371', 'src' => 'aquatic/mar-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '19', 'hp' => '5', 'gold' => '0', 'xp' => '0', 'price' => '200', 'classes' => 'boots-mar'],
                ['id' => '372', 'src' => 'aquatic/mar-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '19', 'hp' => '10', 'gold' => '0', 'xp' => '0', 'price' => '400', 'classes' => 'boots-mar'],
                ['id' => '373', 'src' => 'aquatic/mar-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '19', 'hp' => '20', 'gold' => '0', 'xp' => '0', 'price' => '600', 'classes' => 'boots-mar'],

                ['id' => '374', 'src' => 'aquatic/mar-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '19', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-right-mar'],
                ['id' => '375', 'src' => 'aquatic/mar-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '19', 'hp' => '0', 'gold' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-right-mar'],
                ['id' => '376', 'src' => 'aquatic/mar-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '19', 'hp' => '0', 'gold' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-right-mar'],
                ['id' => '377', 'src' => 'aquatic/mar-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '19', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-right-mar'],
                
                ['id' => '378', 'src' => 'aquatic/mar-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '19', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-left-mar'],
                ['id' => '379', 'src' => 'aquatic/mar-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '19', 'hp' => '0', 'gold' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-left-mar'],
                ['id' => '380', 'src' => 'aquatic/mar-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '19', 'hp' => '0', 'gold' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-left-mar'],
                ['id' => '381', 'src' => 'aquatic/mar-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '19', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-left-mar'],
                
                ['id' => '382', 'src' => 'aquatic/mar-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '19', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'helmet-mar'],
                ['id' => '383', 'src' => 'aquatic/mar-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '19', 'hp' => '0', 'gold' => '5', 'xp' => '5', 'price' => '400', 'classes' => 'helmet-mar'],
                ['id' => '384', 'src' => 'aquatic/mar-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '19', 'hp' => '0', 'gold' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'helmet-mar'],
                ['id' => '385', 'src' => 'aquatic/mar-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '19', 'hp' => '0', 'gold' => '30', 'xp' => '0', 'price' => '800', 'classes' => 'helmet-mar'],
                
                ['id' => '386', 'src' => 'aquatic/mar-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '19', 'hp' => '0', 'gold' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'armor-mar'],
                ['id' => '387', 'src' => 'aquatic/mar-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '19', 'hp' => '5', 'gold' => '5', 'xp' => '5', 'price' => '500', 'classes' => 'armor-mar'],
                ['id' => '388', 'src' => 'aquatic/mar-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '19', 'hp' => '15', 'gold' => '0', 'xp' => '15', 'price' => '800', 'classes' => 'armor-mar'],
                ['id' => '389', 'src' => 'aquatic/mar-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '19', 'hp' => '40', 'gold' => '0', 'xp' => '40', 'price' => '1000', 'classes' => 'armor-mar'],
                

                  
                ['id' => '390', 'src' => 'aquatic/pescadores-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '20', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'boots-pescadores'],
                ['id' => '391', 'src' => 'aquatic/pescadores-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '20', 'gold' => '5', 'hp' => '0', 'xp' => '0', 'price' => '200', 'classes' => 'boots-pescadores'],
                ['id' => '392', 'src' => 'aquatic/pescadores-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '20', 'gold' => '10', 'hp' => '0', 'xp' => '0', 'price' => '400', 'classes' => 'boots-pescadores'],
                ['id' => '393', 'src' => 'aquatic/pescadores-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '20', 'gold' => '20', 'hp' => '0', 'xp' => '0', 'price' => '600', 'classes' => 'boots-pescadores'],

                ['id' => '394', 'src' => 'aquatic/pescadores-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '20', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-right-pescadores'],
                ['id' => '395', 'src' => 'aquatic/pescadores-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '20', 'gold' => '0', 'hp' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-right-pescadores'],
                ['id' => '396', 'src' => 'aquatic/pescadores-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '20', 'gold' => '0', 'hp' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-right-pescadores'],
                ['id' => '397', 'src' => 'aquatic/pescadores-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '20', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-right-pescadores'],
                
                ['id' => '398', 'src' => 'aquatic/pescadores-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '20', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'arm-left-pescadores'],
                ['id' => '399', 'src' => 'aquatic/pescadores-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '20', 'gold' => '0', 'hp' => '5', 'xp' => '0', 'price' => '200', 'classes' => 'arm-left-pescadores'],
                ['id' => '400', 'src' => 'aquatic/pescadores-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '20', 'gold' => '0', 'hp' => '10', 'xp' => '0', 'price' => '400', 'classes' => 'arm-left-pescadores'],
                ['id' => '401', 'src' => 'aquatic/pescadores-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '20', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'arm-left-pescadores'],
                
                ['id' => '402', 'src' => 'aquatic/pescadores-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '20', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'helmet-pescadores'],
                ['id' => '403', 'src' => 'aquatic/pescadores-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '20', 'gold' => '0', 'hp' => '5', 'xp' => '5', 'price' => '400', 'classes' => 'helmet-pescadores'],
                ['id' => '404', 'src' => 'aquatic/pescadores-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '20', 'gold' => '0', 'hp' => '20', 'xp' => '0', 'price' => '600', 'classes' => 'helmet-pescadores'],
                ['id' => '405', 'src' => 'aquatic/pescadores-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '20', 'gold' => '0', 'hp' => '30', 'xp' => '0', 'price' => '800', 'classes' => 'helmet-pescadores'],
                
                ['id' => '406', 'src' => 'aquatic/pescadores-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '20', 'gold' => '0', 'hp' => '0', 'xp' => '0', 'price' => '0', 'classes' => 'armor-pescadores'],
                ['id' => '407', 'src' => 'aquatic/pescadores-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '20', 'gold' => '5', 'hp' => '5', 'xp' => '5', 'price' => '500', 'classes' => 'armor-pescadores'],
                ['id' => '408', 'src' => 'aquatic/pescadores-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '20', 'gold' => '15', 'hp' => '0', 'xp' => '15', 'price' => '800', 'classes' => 'armor-pescadores'],
                ['id' => '409', 'src' => 'aquatic/pescadores-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '20', 'gold' => '40', 'hp' => '0', 'xp' => '40', 'price' => '1000', 'classes' => 'armor-pescadores'],

                

                ['id' => '410', 'src' => 'aquatic/salmuera-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '21', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots-salmuera'],
                ['id' => '411', 'src' => 'aquatic/salmuera-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '21', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'boots-salmuera'],
                ['id' => '412', 'src' => 'aquatic/salmuera-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '21', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '400', 'classes' => 'boots-salmuera'],
                ['id' => '413', 'src' => 'aquatic/salmuera-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '21', 'hp' => '20', 'xp' => '0', 'gold' => '0', 'price' => '600', 'classes' => 'boots-salmuera'],

                ['id' => '414', 'src' => 'aquatic/salmuera-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '21', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-right-salmuera'],
                ['id' => '415', 'src' => 'aquatic/salmuera-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '21', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-right-salmuera'],
                ['id' => '416', 'src' => 'aquatic/salmuera-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '21', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-right-salmuera'],
                ['id' => '417', 'src' => 'aquatic/salmuera-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '21', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-right-salmuera'],
                
                ['id' => '418', 'src' => 'aquatic/salmuera-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '21', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-left-salmuera'],
                ['id' => '419', 'src' => 'aquatic/salmuera-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '21', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-left-salmuera'],
                ['id' => '420', 'src' => 'aquatic/salmuera-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '21', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-left-salmuera'],
                ['id' => '421', 'src' => 'aquatic/salmuera-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '21', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-left-salmuera'],
                
                ['id' => '422', 'src' => 'aquatic/salmuera-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '21', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet-salmuera'],
                ['id' => '423', 'src' => 'aquatic/salmuera-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '21', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'helmet-salmuera'],
                ['id' => '424', 'src' => 'aquatic/salmuera-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '21', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'helmet-salmuera'],
                ['id' => '425', 'src' => 'aquatic/salmuera-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '21', 'hp' => '0', 'xp' => '30', 'gold' => '0', 'price' => '800', 'classes' => 'helmet-salmuera'],
                
                ['id' => '426', 'src' => 'aquatic/salmuera-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '21', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor-salmuera'],
                ['id' => '427', 'src' => 'aquatic/salmuera-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '21', 'hp' => '5', 'xp' => '5', 'gold' => '5', 'price' => '500', 'classes' => 'armor-salmuera'],
                ['id' => '428', 'src' => 'aquatic/salmuera-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '21', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '800', 'classes' => 'armor-salmuera'],
                ['id' => '429', 'src' => 'aquatic/salmuera-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '21', 'hp' => '40', 'xp' => '0', 'gold' => '40', 'price' => '1000', 'classes' => 'armor-salmuera'],
                
                ['id' => '430', 'src' => 'aquatic/xebel-botas1.png', 'offset' => '0', 'type' => '0', 'character_id' => '22', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'boots-xebel'],
                ['id' => '431', 'src' => 'aquatic/xebel-botas2.png', 'offset' => '1', 'type' => '0', 'character_id' => '22', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'price' => '200', 'classes' => 'boots-xebel'],
                ['id' => '432', 'src' => 'aquatic/xebel-botas3.png', 'offset' => '2', 'type' => '0', 'character_id' => '22', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'price' => '400', 'classes' => 'boots-xebel'],
                ['id' => '433', 'src' => 'aquatic/xebel-botas4.png', 'offset' => '3', 'type' => '0', 'character_id' => '22', 'hp' => '20', 'xp' => '0', 'gold' => '0', 'price' => '600', 'classes' => 'boots-xebel'],

                ['id' => '434', 'src' => 'aquatic/xebel-brazoDcho1.png', 'offset' => '0', 'type' => '1', 'character_id' => '22', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-right-xebel'],
                ['id' => '435', 'src' => 'aquatic/xebel-brazoDcho2.png', 'offset' => '1', 'type' => '1', 'character_id' => '22', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-right-xebel'],
                ['id' => '436', 'src' => 'aquatic/xebel-brazoDcho3.png', 'offset' => '2', 'type' => '1', 'character_id' => '22', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-right-xebel'],
                ['id' => '437', 'src' => 'aquatic/xebel-brazoDcho4.png', 'offset' => '3', 'type' => '1', 'character_id' => '22', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-right-xebel'],
                
                ['id' => '438', 'src' => 'aquatic/xebel-brazoIzq1.png', 'offset' => '0', 'type' => '2', 'character_id' => '22', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'arm-left-xebel'],
                ['id' => '439', 'src' => 'aquatic/xebel-brazoIzq2.png', 'offset' => '1', 'type' => '2', 'character_id' => '22', 'hp' => '0', 'xp' => '5', 'gold' => '0', 'price' => '200', 'classes' => 'arm-left-xebel'],
                ['id' => '440', 'src' => 'aquatic/xebel-brazoIzq3.png', 'offset' => '2', 'type' => '2', 'character_id' => '22', 'hp' => '0', 'xp' => '10', 'gold' => '0', 'price' => '400', 'classes' => 'arm-left-xebel'],
                ['id' => '441', 'src' => 'aquatic/xebel-brazoIzq4.png', 'offset' => '3', 'type' => '2', 'character_id' => '22', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'arm-left-xebel'],
                
                ['id' => '442', 'src' => 'aquatic/xebel-cabeza1.png', 'offset' => '0', 'type' => '3', 'character_id' => '22', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'helmet-xebel'],
                ['id' => '443', 'src' => 'aquatic/xebel-cabeza2.png', 'offset' => '1', 'type' => '3', 'character_id' => '22', 'hp' => '0', 'xp' => '5', 'gold' => '5', 'price' => '400', 'classes' => 'helmet-xebel'],
                ['id' => '444', 'src' => 'aquatic/xebel-cabeza3.png', 'offset' => '2', 'type' => '3', 'character_id' => '22', 'hp' => '0', 'xp' => '20', 'gold' => '0', 'price' => '600', 'classes' => 'helmet-xebel'],
                ['id' => '445', 'src' => 'aquatic/xebel-cabeza4.png', 'offset' => '3', 'type' => '3', 'character_id' => '22', 'hp' => '0', 'xp' => '30', 'gold' => '0', 'price' => '800', 'classes' => 'helmet-xebel'],
                
                ['id' => '446', 'src' => 'aquatic/xebel-cuerpo1.png', 'offset' => '0', 'type' => '4', 'character_id' => '22', 'hp' => '0', 'xp' => '0', 'gold' => '0', 'price' => '0', 'classes' => 'armor-xebel'],
                ['id' => '447', 'src' => 'aquatic/xebel-cuerpo2.png', 'offset' => '1', 'type' => '4', 'character_id' => '22', 'hp' => '5', 'xp' => '5', 'gold' => '5', 'price' => '500', 'classes' => 'armor-xebel'],
                ['id' => '448', 'src' => 'aquatic/xebel-cuerpo3.png', 'offset' => '2', 'type' => '4', 'character_id' => '22', 'hp' => '15', 'xp' => '0', 'gold' => '15', 'price' => '800', 'classes' => 'armor-xebel'],
                ['id' => '449', 'src' => 'aquatic/xebel-cuerpo4.png', 'offset' => '3', 'type' => '4', 'character_id' => '22', 'hp' => '40', 'xp' => '0', 'gold' => '40', 'price' => '1000', 'classes' => 'armor-xebel'],
                

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
