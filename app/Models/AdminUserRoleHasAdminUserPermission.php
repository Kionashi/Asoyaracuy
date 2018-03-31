<?php

namespace App\Models;

class AdminUserRoleHasAdminUserPermission extends RDNModel
{
	public $timestamps = false;
	public $table = 'admin_user_role_has_permission';
	protected $fillable = ['admin_user_role_id', 'admin_user_permission_id'];

 	public function adminUserRole()
    {
        return $this->belongsTo('App\Models\AdminUserRole');
    }
	public function adminUserPermission()
    {
        return $this->belongsTo('App\Models\AdminUserPermission');
    }
    
}