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
        ]);
    }
}
