<?php

use Illuminate\Database\Seeder;
use App\Models\AdminUser;

class InitialAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	// Admin user
    	$adminUser = new AdminUser();
		$adminUser->id = 1;
		$adminUser->enabled = true;
	   	$adminUser->email = "admin@mail.com";
	    $adminUser->firstName = "Víctor";
		$adminUser->lastName = "Cardozo";
    	$adminUser->password = "7c4a8d09ca3762af61e59520943dc26494f8941b";
    	$adminUser->phone = "5555555";
    	$adminUser->type = 1;
    	$adminUser->save();
    	
    	// Add admin role
    	$adminUser->adminUserRoles()->attach(1);
    	$adminUser->save();
    	
    }
}
