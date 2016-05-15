<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
    			'name' => 'Administrator',
    			'email' => 'admin@admin.com',
    			'password' => bcrypt('topsecret'),
    	]);
    	DB::table('users')->insert([
    			'name' => 'Moderator',
    			'email' => 'mod@mod.com',
    			'password' => bcrypt('topsecret'),
    	]);
    	DB::table('users')->insert([
    			'name' => 'User',
    			'email' => 'user@user.com',
    			'password' => bcrypt('topsecret'),
    	]);
    }
}
