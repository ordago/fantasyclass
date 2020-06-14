<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "admin",
            'username' => "admin",
            'email' => 'admin@gamifica.online',
            'email_verified_at' => '2020-05-03 19:21:43',
            'password' => Hash::make('admin'),
            'locale' => 'en',
        ]);

        DB::table('classrooms')->insert([
            'name' => 'First',
            'adventure_name' => 'FantasyClass',
            'code' => 'temporal',
            'enrollment_code' => '123456',
            'theme_id' => '19',
            'goal_type' => '1',
            'character_theme' => '1',
        ]);

        DB::table('classroom_user')->insert([
            [
                'user_id' => 1,
                'classroom_id' => 1,
                'role' => 2,
            ], 
            [
                'user_id' => 1,
                'classroom_id' => 1,
                'role' => 0,
            ]
        ]);

        DB::table('students')->insert([
            'name' => 'Joan C',
            'classroom_user_id' => 2,
            'character_id' => 1,
        ]);

        DB::table('groupings')->insert([
            'name' => 'General',
            'classroom_id' => 1,
        ]);
    }
}
