<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddKoiChar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        DB::table('equipment')->insert(
            [
                // Delumion gold
                ['id' => '800','src' => 'koi/delumion_base.png', 'offset' => '0', 'type' => '99','character_id' => '[51]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'delumion-body'],
                ['id' => '801','src' => 'koi/ganabia_base.png', 'offset' => '0', 'type' => '99','character_id' => '[52]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ganabia-body'],
                ['id' => '802','src' => 'koi/mundaraka_base.png', 'offset' => '0', 'type' => '99','character_id' => '[53]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'mundaraka-body'],
                ['id' => '803','src' => 'koi/laiona_base.png', 'offset' => '0', 'type' => '99','character_id' => '[54]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'laiona-body'],
                ['id' => '804','src' => 'koi/ionare_base.png', 'offset' => '0', 'type' => '99','character_id' => '[55]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ionare-body'],
                ['id' => '805','src' => 'koi/gespair_base.png', 'offset' => '0', 'type' => '99','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'gespair-body'],
                ['id' => '806','src' => 'koi/ganabia_hand.png', 'offset' => '0', 'type' => '99','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ganabia-hand'],
                ['id' => '807','src' => 'koi/laiona_eye.png', 'offset' => '0', 'type' => '99','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'laiona-eye'],
                ['id' => '808','src' => 'koi/mundaraka_head.png', 'offset' => '0', 'type' => '99','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'mundaraka-head'],
                ['id' => '809','src' => 'koi/ionare_tail.png', 'offset' => '0', 'type' => '99','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ionare-tail'],
                ['id' => '810','src' => 'koi/whip.gif', 'offset' => '0', 'type' => '99','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ionare-whip'],
                ['id' => '811','src' => 'koi/gespair_tail_left.png', 'offset' => '0', 'type' => '99','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'gespair-tail-left'],
                
                ['id' => '820','src' => 'koi/delumion_cape_0.png', 'offset' => '0', 'type' => '0','character_id' => '[51]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'delumion-cape'],
                ['id' => '821','src' => 'koi/delumion_cape_1.png', 'offset' => '1', 'type' => '0','character_id' => '[51]','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'delumion-cape'],
                ['id' => '822','src' => 'koi/delumion_cape_2.png', 'offset' => '2', 'type' => '0','character_id' => '[51]','hp' => '10','xp' => '0','gold' => '10','price' => '1000', 'classes' => 'delumion-cape'],
                ['id' => '823','src' => 'koi/delumion_cape_3.png', 'offset' => '3', 'type' => '0','character_id' => '[51]','hp' => '20','xp' => '0','gold' => '20','price' => '1200', 'classes' => 'delumion-cape'],
                
                ['id' => '824','src' => 'koi/delumion_staff_0.png', 'offset' => '0', 'type' => '1','character_id' => '[51]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'delumion-staff'],
                ['id' => '825','src' => 'koi/delumion_staff_1.png', 'offset' => '1', 'type' => '1','character_id' => '[51]','hp' => '5','xp' => '5','gold' => '5','price' => '700', 'classes' => 'delumion-staff'],
                ['id' => '826','src' => 'koi/delumion_staff_2.png', 'offset' => '2', 'type' => '1','character_id' => '[51]','hp' => '10','xp' => '10','gold' => '5','price' => '800', 'classes' => 'delumion-staff'],
                ['id' => '827','src' => 'koi/delumion_staff_3.png', 'offset' => '3', 'type' => '1','character_id' => '[51]','hp' => '20','xp' => '20','gold' => '10','price' => '1200', 'classes' => 'delumion-staff'],
                
                ['id' => '828','src' => 'koi/pet_empty.png', 'offset' => '0', 'type' => '2','character_id' => '[51]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'koi-pet-ground'],
                ['id' => '829','src' => 'koi/pet_cheloko.png', 'offset' => '1', 'type' => '2','character_id' => '[51]','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'koi-pet-fly'],
                ['id' => '830','src' => 'koi/pet_kotzail.png', 'offset' => '1', 'type' => '2','character_id' => '[51]','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'koi-pet-fly'],
                ['id' => '831','src' => 'koi/pet_davitan.png', 'offset' => '2', 'type' => '2','character_id' => '[51]','hp' => '0','xp' => '10','gold' => '10','price' => '800', 'classes' => 'koi-pet-ground'],
                ['id' => '832','src' => 'koi/pet_arwen.png', 'offset' => '2', 'type' => '2','character_id' => '[51]','hp' => '0','xp' => '10','gold' => '10','price' => '800', 'classes' => 'koi-pet-ground'],
                ['id' => '833','src' => 'koi/pet_silabella.png', 'offset' => '3', 'type' => '2','character_id' => '[51]','hp' => '0','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'koi-pet-fly'],
                ['id' => '834','src' => 'koi/pet_llidrac.png', 'offset' => '3', 'type' => '2','character_id' => '[51]','hp' => '0','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'koi-pet-fly'],
               
                // Ganabia gold
                ['id' => '840','src' => 'koi/ganabia_hair_0.png', 'offset' => '0', 'type' => '0','character_id' => '[52]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ganabia-hair'],
                ['id' => '841','src' => 'koi/ganabia_hair_1.png', 'offset' => '1', 'type' => '0','character_id' => '[52]','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'ganabia-hair'],
                ['id' => '842','src' => 'koi/ganabia_hair_2.png', 'offset' => '2', 'type' => '0','character_id' => '[52]','hp' => '10','xp' => '0','gold' => '10','price' => '1000', 'classes' => 'ganabia-hair'],
                ['id' => '843','src' => 'koi/ganabia_hair_3.png', 'offset' => '3', 'type' => '0','character_id' => '[52]','hp' => '20','xp' => '0','gold' => '20','price' => '1200', 'classes' => 'ganabia-hair'],
                
                ['id' => '844','src' => 'koi/ganabia_trident_0.png', 'offset' => '0', 'type' => '1','character_id' => '[52]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ganabia-trident'],
                ['id' => '845','src' => 'koi/ganabia_trident_1.png', 'offset' => '1', 'type' => '1','character_id' => '[52]','hp' => '5','xp' => '5','gold' => '5','price' => '700', 'classes' => 'ganabia-trident'],
                ['id' => '846','src' => 'koi/ganabia_trident_2.png', 'offset' => '2', 'type' => '1','character_id' => '[52]','hp' => '10','xp' => '10','gold' => '5','price' => '800', 'classes' => 'ganabia-trident'],
                ['id' => '847','src' => 'koi/ganabia_trident_3.png', 'offset' => '3', 'type' => '1','character_id' => '[52]','hp' => '20','xp' => '20','gold' => '10','price' => '1200', 'classes' => 'ganabia-trident'],
                
                ['id' => '848','src' => 'koi/pet_empty.png', 'offset' => '0', 'type' => '2','character_id' => '[52]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'koi-pet-ground'],
                ['id' => '849','src' => 'koi/pet_cheloko.png', 'offset' => '1', 'type' => '2','character_id' => '[52]','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'koi-pet-fly'],
                ['id' => '850','src' => 'koi/pet_kotzail.png', 'offset' => '1', 'type' => '2','character_id' => '[52]','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'koi-pet-fly'],
                ['id' => '851','src' => 'koi/pet_davitan.png', 'offset' => '2', 'type' => '2','character_id' => '[52]','hp' => '0','xp' => '10','gold' => '10','price' => '800', 'classes' => 'koi-pet-ground'],
                ['id' => '852','src' => 'koi/pet_arwen.png', 'offset' => '2', 'type' => '2','character_id' => '[52]','hp' => '0','xp' => '10','gold' => '10','price' => '800', 'classes' => 'koi-pet-ground'],
                ['id' => '853','src' => 'koi/pet_silabella.png', 'offset' => '3', 'type' => '2','character_id' => '[52]','hp' => '0','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'koi-pet-fly'],
                ['id' => '854','src' => 'koi/pet_llidrac.png', 'offset' => '3', 'type' => '2','character_id' => '[52]','hp' => '0','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'koi-pet-fly'],
               
                // Mundaraka hp
                ['id' => '860','src' => 'koi/mundaraka_cap_0.png', 'offset' => '0', 'type' => '0','character_id' => '[53]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'mundaraka-cap'],
                ['id' => '861','src' => 'koi/mundaraka_cap_1.png', 'offset' => '1', 'type' => '0','character_id' => '[53]','hp' => '5','xp' => '5','gold' => '0','price' => '400', 'classes' => 'mundaraka-cap'],
                ['id' => '862','src' => 'koi/mundaraka_cap_2.png', 'offset' => '2', 'type' => '0','character_id' => '[53]','hp' => '10','xp' => '10','gold' => '0','price' => '1000', 'classes' => 'mundaraka-cap'],
                ['id' => '863','src' => 'koi/mundaraka_cap_3.png', 'offset' => '3', 'type' => '0','character_id' => '[53]','hp' => '20','xp' => '20','gold' => '0','price' => '1200', 'classes' => 'mundaraka-cap'],
                
                ['id' => '864','src' => 'koi/mundaraka_surf_0.png', 'offset' => '0', 'type' => '1','character_id' => '[53]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'mundaraka-surf'],
                ['id' => '865','src' => 'koi/mundaraka_surf_1.png', 'offset' => '1', 'type' => '1','character_id' => '[53]','hp' => '5','xp' => '5','gold' => '5','price' => '700', 'classes' => 'mundaraka-surf'],
                ['id' => '866','src' => 'koi/mundaraka_surf_2.png', 'offset' => '2', 'type' => '1','character_id' => '[53]','hp' => '5','xp' => '10','gold' => '10','price' => '800', 'classes' => 'mundaraka-surf'],
                ['id' => '867','src' => 'koi/mundaraka_surf_3.png', 'offset' => '3', 'type' => '1','character_id' => '[53]','hp' => '10','xp' => '20','gold' => '20','price' => '1200', 'classes' => 'mundaraka-surf'],
                
                ['id' => '868','src' => 'koi/pet_empty.png', 'offset' => '0', 'type' => '2','character_id' => '[53]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'koi-pet-ground'],
                ['id' => '869','src' => 'koi/pet_davitan.png', 'offset' => '1', 'type' => '2','character_id' => '[53]','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'koi-pet-ground'],
                ['id' => '870','src' => 'koi/pet_arwen.png', 'offset' => '1', 'type' => '2','character_id' => '[53]','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'koi-pet-ground'],
                ['id' => '871','src' => 'koi/pet_silabella.png', 'offset' => '2', 'type' => '2','character_id' => '[53]','hp' => '10','xp' => '0','gold' => '10','price' => '800', 'classes' => 'koi-pet-fly'],
                ['id' => '872','src' => 'koi/pet_llidrac.png', 'offset' => '2', 'type' => '2','character_id' => '[53]','hp' => '10','xp' => '0','gold' => '10','price' => '800', 'classes' => 'koi-pet-fly'],
                ['id' => '873','src' => 'koi/pet_cheloko.png', 'offset' => '3', 'type' => '2','character_id' => '[53]','hp' => '20','xp' => '0','gold' => '20','price' => '1600', 'classes' => 'koi-pet-fly'],
                ['id' => '874','src' => 'koi/pet_kotzail.png', 'offset' => '3', 'type' => '2','character_id' => '[53]','hp' => '20','xp' => '0','gold' => '20','price' => '1600', 'classes' => 'koi-pet-fly'],
               
                // Laiona hp
                ['id' => '880','src' => 'koi/laiona_belt_0.png', 'offset' => '0', 'type' => '0','character_id' => '[54]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'laiona-belt'],
                ['id' => '881','src' => 'koi/laiona_belt_1.png', 'offset' => '1', 'type' => '0','character_id' => '[54]','hp' => '5','xp' => '5','gold' => '0','price' => '400', 'classes' => 'laiona-belt'],
                ['id' => '882','src' => 'koi/laiona_belt_2.png', 'offset' => '2', 'type' => '0','character_id' => '[54]','hp' => '10','xp' => '10','gold' => '0','price' => '1000', 'classes' => 'laiona-belt'],
                ['id' => '883','src' => 'koi/laiona_belt_3.png', 'offset' => '3', 'type' => '0','character_id' => '[54]','hp' => '20','xp' => '20','gold' => '0','price' => '1200', 'classes' => 'laiona-belt'],
                
                ['id' => '884','src' => 'koi/laiona_mono_0.png', 'offset' => '0', 'type' => '1','character_id' => '[54]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'laiona-mono'],
                ['id' => '885','src' => 'koi/laiona_mono_1.png', 'offset' => '1', 'type' => '1','character_id' => '[54]','hp' => '5','xp' => '5','gold' => '5','price' => '700', 'classes' => 'laiona-mono'],
                ['id' => '886','src' => 'koi/laiona_mono_2.png', 'offset' => '2', 'type' => '1','character_id' => '[54]','hp' => '5','xp' => '10','gold' => '10','price' => '800', 'classes' => 'laiona-mono'],
                ['id' => '887','src' => 'koi/laiona_mono_3.png', 'offset' => '3', 'type' => '1','character_id' => '[54]','hp' => '10','xp' => '20','gold' => '20','price' => '1200', 'classes' => 'laiona-mono'],
                
                ['id' => '888','src' => 'koi/pet_empty.png', 'offset' => '0', 'type' => '2','character_id' => '[54]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'koi-pet-ground'],
                ['id' => '889','src' => 'koi/pet_davitan.png', 'offset' => '1', 'type' => '2','character_id' => '[54]','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'koi-pet-ground'],
                ['id' => '890','src' => 'koi/pet_arwen.png', 'offset' => '1', 'type' => '2','character_id' => '[54]','hp' => '5','xp' => '0','gold' => '5','price' => '400', 'classes' => 'koi-pet-ground'],
                ['id' => '891','src' => 'koi/pet_silabella.png', 'offset' => '2', 'type' => '2','character_id' => '[54]','hp' => '10','xp' => '0','gold' => '10','price' => '800', 'classes' => 'koi-pet-fly'],
                ['id' => '892','src' => 'koi/pet_llidrac.png', 'offset' => '2', 'type' => '2','character_id' => '[54]','hp' => '10','xp' => '0','gold' => '10','price' => '800', 'classes' => 'koi-pet-fly'],
                ['id' => '893','src' => 'koi/pet_cheloko.png', 'offset' => '3', 'type' => '2','character_id' => '[54]','hp' => '20','xp' => '0','gold' => '20','price' => '1600', 'classes' => 'koi-pet-fly'],
                ['id' => '894','src' => 'koi/pet_kotzail.png', 'offset' => '3', 'type' => '2','character_id' => '[54]','hp' => '20','xp' => '0','gold' => '20','price' => '1600', 'classes' => 'koi-pet-fly'],
                
                // Ionare XP
                ['id' => '900','src' => 'koi/ionare_tatoo_0.png', 'offset' => '0', 'type' => '0','character_id' => '[55]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ionare-tatoo'],
                ['id' => '901','src' => 'koi/ionare_tatoo_1.png', 'offset' => '1', 'type' => '0','character_id' => '[55]','hp' => '5','xp' => '5','gold' => '0','price' => '400', 'classes' => 'ionare-tatoo'],
                ['id' => '902','src' => 'koi/ionare_tatoo_2.png', 'offset' => '2', 'type' => '0','character_id' => '[55]','hp' => '10','xp' => '10','gold' => '0','price' => '1000', 'classes' => 'ionare-tatoo'],
                ['id' => '903','src' => 'koi/ionare_tatoo_3.png', 'offset' => '3', 'type' => '0','character_id' => '[55]','hp' => '20','xp' => '20','gold' => '0','price' => '1200', 'classes' => 'ionare-tatoo'],
                
                ['id' => '904','src' => 'koi/ionare_weapons_0.png', 'offset' => '0', 'type' => '1','character_id' => '[55]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'ionare-weapons'],
                ['id' => '905','src' => 'koi/ionare_weapons_1.png', 'offset' => '1', 'type' => '1','character_id' => '[55]','hp' => '5','xp' => '5','gold' => '5','price' => '700', 'classes' => 'ionare-weapons'],
                ['id' => '906','src' => 'koi/ionare_weapons_2.png', 'offset' => '2', 'type' => '1','character_id' => '[55]','hp' => '10','xp' => '5','gold' => '10','price' => '800', 'classes' => 'ionare-weapons'],
                ['id' => '907','src' => 'koi/ionare_weapons_3.png', 'offset' => '3', 'type' => '1','character_id' => '[55]','hp' => '20','xp' => '10','gold' => '20','price' => '1200', 'classes' => 'ionare-weapons'],
                
                ['id' => '908','src' => 'koi/pet_empty.png', 'offset' => '0', 'type' => '2','character_id' => '[55]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'koi-pet-ground'],
                ['id' => '909','src' => 'koi/pet_silabella.png', 'offset' => '1', 'type' => '2','character_id' => '[55]','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'koi-pet-fly-ionare'],
                ['id' => '910','src' => 'koi/pet_llidrac.png', 'offset' => '1', 'type' => '2','character_id' => '[55]','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'koi-pet-fly-ionare'],
                ['id' => '911','src' => 'koi/pet_cheloko.png', 'offset' => '2', 'type' => '2','character_id' => '[55]','hp' => '0','xp' => '10','gold' => '10','price' => '800', 'classes' => 'koi-pet-fly-ionare'],
                ['id' => '912','src' => 'koi/pet_kotzail.png', 'offset' => '2', 'type' => '2','character_id' => '[55]','hp' => '0','xp' => '10','gold' => '10','price' => '800', 'classes' => 'koi-pet-fly-ionare'],
                ['id' => '913','src' => 'koi/pet_davitan.png', 'offset' => '3', 'type' => '2','character_id' => '[55]','hp' => '0','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'koi-pet-ground-ionare'],
                ['id' => '914','src' => 'koi/pet_arwen.png', 'offset' => '3', 'type' => '2','character_id' => '[55]','hp' => '0','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'koi-pet-ground-ionare'],
                   
                
                // Gespair XP
                ['id' => '920','src' => 'koi/gespair_arms_0.png', 'offset' => '0', 'type' => '0','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'gespair-arms'],
                ['id' => '921','src' => 'koi/gespair_arms_1.png', 'offset' => '1', 'type' => '0','character_id' => '[56]','hp' => '5','xp' => '5','gold' => '0','price' => '400', 'classes' => 'gespair-arms'],
                ['id' => '922','src' => 'koi/gespair_arms_2.png', 'offset' => '2', 'type' => '0','character_id' => '[56]','hp' => '10','xp' => '10','gold' => '0','price' => '1000', 'classes' => 'gespair-arms'],
                ['id' => '923','src' => 'koi/gespair_arms_3.png', 'offset' => '3', 'type' => '0','character_id' => '[56]','hp' => '20','xp' => '20','gold' => '0','price' => '1200', 'classes' => 'gespair-arms'],
                
                ['id' => '924','src' => 'koi/gespair_tail_0.png', 'offset' => '0', 'type' => '1','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'gespair-tail'],
                ['id' => '925','src' => 'koi/gespair_tail_1.png', 'offset' => '1', 'type' => '1','character_id' => '[56]','hp' => '5','xp' => '5','gold' => '5','price' => '700', 'classes' => 'gespair-tail'],
                ['id' => '926','src' => 'koi/gespair_tail_2.png', 'offset' => '2', 'type' => '1','character_id' => '[56]','hp' => '10','xp' => '5','gold' => '10','price' => '800', 'classes' => 'gespair-tail'],
                ['id' => '927','src' => 'koi/gespair_tail_3.png', 'offset' => '3', 'type' => '1','character_id' => '[56]','hp' => '20','xp' => '10','gold' => '20','price' => '1200', 'classes' => 'gespair-tail'],
                
                ['id' => '928','src' => 'koi/pet_empty.png', 'offset' => '0', 'type' => '2','character_id' => '[56]','hp' => '0','xp' => '0','gold' => '0','price' => '0', 'classes' => 'koi-pet-ground'],
                ['id' => '929','src' => 'koi/pet_silabella.png', 'offset' => '1', 'type' => '2','character_id' => '[56]','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'koi-pet-fly'],
                ['id' => '930','src' => 'koi/pet_llidrac.png', 'offset' => '1', 'type' => '2','character_id' => '[56]','hp' => '0','xp' => '5','gold' => '5','price' => '400', 'classes' => 'koi-pet-fly'],
                ['id' => '931','src' => 'koi/pet_cheloko.png', 'offset' => '2', 'type' => '2','character_id' => '[56]','hp' => '0','xp' => '10','gold' => '10','price' => '800', 'classes' => 'koi-pet-fly'],
                ['id' => '932','src' => 'koi/pet_kotzail.png', 'offset' => '2', 'type' => '2','character_id' => '[56]','hp' => '0','xp' => '10','gold' => '10','price' => '800', 'classes' => 'koi-pet-fly'],
                ['id' => '933','src' => 'koi/pet_davitan.png', 'offset' => '3', 'type' => '2','character_id' => '[56]','hp' => '0','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'koi-pet-ground'],
                ['id' => '934','src' => 'koi/pet_arwen.png', 'offset' => '3', 'type' => '2','character_id' => '[56]','hp' => '0','xp' => '20','gold' => '20','price' => '1600', 'classes' => 'koi-pet-ground'],
                   
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
