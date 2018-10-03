<?php

use Illuminate\Database\Seeder;
use App\Models\AdminUserPermission;
use App\Enums\AdminUserType;

class InitialAdminUserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        /*********************************************************************************
         * ADMIN PERMISSIONS
         ********************************************************************************/
        
        // Account
        $this->addAdminPermission("ACC", "Account", "account");
        $this->addAdminPermission("ACC", "Account change password", "account/change-password");
        
        // Admin User Password Recovery Permissions
        $this->addAdminPermission("AUP", "List Admin user password recoveries", "management/admin-user-password-recoveries");
        
        // Admin User Permissions
        $this->addAdminPermission("ADU", "Add Admin users", "management/admin-users/add");
        $this->addAdminPermission("ADU", "Delete Admin users", "management/admin-users/delete");
        $this->addAdminPermission("ADU", "Edit Admin users", "management/admin-users/edit");
        $this->addAdminPermission("ADU", "List Admin users", "management/admin-users");
        $this->addAdminPermission("ADU", "View Admin users", "management/admin-users/detail");
        $this->addAdminPermission("ADU", "Change Password Admin users", "management/admin-users/change-password"); 
        
        // Admin User Role Permissions
        $this->addAdminPermission("ADR", "Add Admin user roles", "management/admin-user-roles/add");
        $this->addAdminPermission("ADR", "Delete Admin user roles", "management/admin-user-roles/delete");
        $this->addAdminPermission("ADR", "Edit Admin user roles", "management/admin-user-roles/edit");
        $this->addAdminPermission("ADR", "List Admin user roles", "management/admin-user-roles");
        $this->addAdminPermission("ADR", "View Admin user roles", "management/admin-user-roles/detail");
        
        // Audit Permissions
        $this->addAdminPermission("AUD", "List of auditories", "audits");
        $this->addAdminPermission("AUD", "View of auditories", "audits/detail");
        
        // Config Item Permissions
        $this->addAdminPermission("COI", "Edit Config Items", "management/config-items/edit");
        $this->addAdminPermission("COI", "List Config Items", "management/config-items");
        $this->addAdminPermission("COI", "View Config Items", "management/config-items/detail");
        
        // Contact Permissions
        $this->addAdminPermission("CON", "List Contacts", "management/contacts");
        $this->addAdminPermission("CON", "View Contacts", "management/contacts/detail");
        
        // Contact Reason Permissions
        $this->addAdminPermission("COR", "Add Contact reasons", "management/contact-reasons/add");
        $this->addAdminPermission("COR", "Delete Contact reasons", "management/contact-reasons/delete");
        $this->addAdminPermission("COR", "Edit Contact reasons", "management/contact-reasons/edit");
        $this->addAdminPermission("COR", "List Contact reasons", "management/contact-reasons");
        $this->addAdminPermission("COR", "View Contact reasons", "management/contact-reasons/detail");
        
        // Dashboard Permissions
        $this->addAdminPermission("DSB", "Dashboard", "dashboard");
        
        // Payment Permissions
        $this->addAdminPermission("PAY", "List of payments", "management/payments");
        $this->addAdminPermission("PAY", "View payments", "management/payments/detail");
        $this->addAdminPermission("PAY", "Approve payment", "management/payments/approve");
        $this->addAdminPermission("PAY", "Reject payment", "management/payments/reject");
        
        // Polls Permissions
        $this->addAdminPermission("POL", "Poll Result", "management/polls/result");
        $this->addAdminPermission("POL", "Add Poll", "management/polls/add");
        $this->addAdminPermission("POL", "Delete Poll", "management/polls/delete");
        $this->addAdminPermission("POL", "Edit Poll", "management/polls/edit");
        $this->addAdminPermission("POL", "List Poll", "management/polls");
        $this->addAdminPermission("POL", "View Poll", "management/polls/detail");
        
        // Static Content Permissions
        $this->addAdminPermission("STC", "Add Static content", "management/static-contents/add");
        $this->addAdminPermission("STC", "Delete Static content", "management/static-contents/delete");
        $this->addAdminPermission("STC", "Edit Static content", "management/static-contents/edit");
        $this->addAdminPermission("STC", "List Static content", "management/static-contents");
        $this->addAdminPermission("STC", "View Static content", "management/static-contents/detail");
        
        // User Permissions
        $this->addAdminPermission("USR", "Add User", "management/users/add");
        $this->addAdminPermission("USR", "Delete User", "management/users/delete");
        $this->addAdminPermission("USR", "Edit User", "management/users/edit");
        $this->addAdminPermission("USR", "List User", "management/users");
        $this->addAdminPermission("USR", "View User", "management/users/detail");
        $this->addAdminPermission("USR", "Change User's password", "management/users/change-password");

        //Fee Permissions
        $this->addAdminPermission("FEE", "View and create Fees", "management/fees");

        //Collection Permissions
        
        $this->addAdminPermission("COL", "View Collection", "collection");
        $this->addAdminPermission("COL", "Create Collection", "collection/add");


        
    }

    private function addAdminPermission($code, $name, $url) {
        $this->addAdminUserPermission($code, $name, $url, AdminUserType::ADMIN);
    }
    
    private function addAdminUserPermission($code, $name, $url, $type) {
        // Count existing permissions with same code
        $countPermissions = AdminUserPermission::where('code', 'like', '%'.$code.'%')
            ->count()
        ;
        
        // Generate new permission code
        $code = $code.'-'.sprintf('%04d', $countPermissions + 1);
        
        $adminUserPermission = new AdminUserPermission();
        
        switch($type) {
            case AdminUserType::ADMIN:
                $code = 'ADM-' . $code;
                break;
        }
        $adminUserPermission->code = $code;
        $adminUserPermission->enabled = true;
        $adminUserPermission->hidden = false;
        $adminUserPermission->name = $name;
        $adminUserPermission->admin_user_type = $type;
        $adminUserPermission->url = $url;
        $adminUserPermission->save();
    }
}
