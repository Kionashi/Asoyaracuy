<?php

namespace App\Models;

class AdminUserPermission extends RDNModel
{
	public $timestamps = false;
	public $table = 'admin_user_permission';
	protected $fillable = ['code', 'enabled','hidden', 'name', 'admin_user_type', 'url'];
    
	public function adminUserRoles()
	{
		return $this->belongsToMany('App\Models\AdminUserRole');
	}
	
}