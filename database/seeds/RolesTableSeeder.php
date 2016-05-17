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
            'name' => 'admin',
            'display_name' => 'admin',
            'description' => 'administrator',
        ]);
        DB::table('roles')->insert([
        		'name' => 'mod',
        		'display_name' => 'mod',
        		'description' => 'moderator',
        ]);
        DB::table('roles')->insert([
        		'name' => 'sub',
        		'display_name' => 'sub',
        		'description' => 'Registered User',
        ]);
    	
        $adminUser = User::where('name','=','Administrator')->first();
        $admin = Role::where('name', '=', 'admin')->first(); 
        $adminUser->attachRole($admin);
        
        $moderatorUser = User::where('name', '=', 'Moderator')->first();
        $moderator = Role::where('name','=','mod')->first();
        $moderatorUser->attachRole($moderator);
         
        $subscriberUser = User::where('name', '=', 'User')->first();
        $subscriber = Role::where('name','=','sub')->first();
        $subscriberUser->attachRole($subscriber);
        
    }
}
