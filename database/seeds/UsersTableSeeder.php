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
    	
    	/*$adminUser = User::where('name','Administrator')->first();
    	$admin = Role::where('name','Administrator');
    	$adminUser->attachRole($admin); */
    	//UsersTableSeeder::createUsers();
    }
    /*protected function createUsers()
    {
    	$adminUser = User::where('name', '=', 'Administrator')->get()->first();
    	$admin = Role::where('name','=','Administrator');
    	$adminUser->attachRole($admin); 
    	
    	$moderatorUser = User::where('name', '=', 'Moderator')->get()->first();
    	$moderator = Role::where('name','=','Moderator');
    	$moderatorUser->attachRole($moderator);
    	
    	$subscriberUser = User::where('name', '=', 'User')->get()->first();
    	$subscriber = Role::where('name','=','User');
    	$subscriberUser->attachRole($subscriber);
    	
    	//return $adminUser; $moderatorUser; $subscriberUser;
    }*/
}
