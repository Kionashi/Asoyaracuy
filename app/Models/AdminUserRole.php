<?php

namespace App\Models;

class AdminUserRole extends RDNModel
{
	public $timestamps = false;
	public $table = 'admin_user_role';
	protected $fillable = ['name', 'enabled', 'admin_user_type'];
	
	public function adminUsers()
	{
		return $this->belongsToMany('App\Models\AdminUser');
	}
	public function permissions()
	{
		return $this->belongsToMany('App\Models\AdminUserPermission', 'admin_user_role_has_permission');
	}
	public function enabledPermissions() {
		// Get enabled Permissions
		return $this->permissions()
				->where('enabled', true)
				->get()
		;
	}
	
}