<?php

use Illuminate\Database\Seeder;
use App\Models\AdminUserRole;
use App\Models\AdminUserPermission;
use App\Enums\AdminUserType;

class InitialAdminUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin role
        $adminUserRole = new AdminUserRole();
        $adminUserRole->id = 1;
        $adminUserRole->name = "Admin";
        $adminUserRole->enabled = true;
        $adminUserRole->adminUserType = 1;
        $adminUserRole->save();
        
        // Add all permissions
        $adminUserPermissions = AdminUserPermission::where('admin_user_type', AdminUserType::ADMIN)
            ->get()
        ;
        $adminUserRole->permissions()->attach($adminUserPermissions);
        $adminUserRole->save();
        
    }
}
