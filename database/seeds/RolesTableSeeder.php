<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'display_name' => 'Admin',
            'description' => 'Administrator',
        ]);
        DB::table('roles')->insert([
        		'name' => 'Moderator',
        		'display_name' => 'Mod',
        		'description' => 'Moderator',
        ]);
        DB::table('roles')->insert([
        		'name' => 'Subscriber',
        		'display_name' => 'Sub',
        		'description' => 'Registered User',
        ]);
    	
        $adminUser = User::where('name','=','Administrator')->first();
        $admin = Role::where('name', '=', 'Administrator')->first(); 
        $adminUser->attachRole($admin);
        
        $moderatorUser = User::where('name', '=', 'Moderator')->first();
        $moderator = Role::where('name','=','Moderator')->first();
        $moderatorUser->attachRole($moderator);
         
        $subscriberUser = User::where('name', '=', 'User')->first();
        $subscriber = Role::where('name','=','Subscriber')->first();
        $subscriberUser->attachRole($subscriber);
        
    }
}
