<?php

namespace App\Models;

class AdminUser extends RDNModel
{
    public $timestamps = true;
    public $table = 'admin_user';
    protected $fillable = ['email', 'enabled', 'first_name', 'last_name', 'password', 'phone', 'type'];
    
    public function adminUserPasswordRecoveries()
    {
        return $this->hasMany('App\Models\AdminUserPasswordRecovery');
    }
    
    public function adminUserRoles()
    {
        return $this->belongsToMany('App\Models\AdminUserRole', 'admin_user_has_role'); 
    }
    
    public static function authenticate($email,$password)
    {
        // Authenticates an admin user
        $adminUser = AdminUser::where('enabled', true)
            ->where('email', $email)
            ->where('password', sha1($password))
            ->first()
        ;
        
        return $adminUser;
    }
    
    public function enabledRoles() {

        // Get enabled Roles
        return $this->adminUserRoles()
            ->where('enabled', true)
            ->get()
        ;
    }
    
    public function fullName()
    {
        return $this->firstName.' '.$this->lastName;
    }
}