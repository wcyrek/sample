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
        //input 10 random users
    	for ($i = 0; $i < 10; $i++) { 
     	DB::table('users')->insert([
             'name' => str_random(8),
             'email' => str_random(12).'@mail.com',
             'password' => bcrypt('secret')
         ]);
    	}
    }
}
