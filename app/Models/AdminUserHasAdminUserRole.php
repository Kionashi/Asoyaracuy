<?php

namespace App\Models;

class AdminUserHasAdminUserRole extends RDNModel
{
	public $timestamps = false;
	public $table = 'admin_user_has_role';
	protected $fillable = ['admin_user_id', 'admin_user_role_id'];

	public function adminUser()
    {
        return $this->belongsTo('App\Models\AdminUser');
    }
    
 	public function adminUserRole()
    {
        return $this->belongsTo('App\Models\AdminUserRole');
    }
    
    public static function updateEnabledRoles($id,$enabled) 
    {
    	AdminUserHasAdminUserRole::where('admin_user_role_id', $id)
    		->update(array('enabled'=> $enabled));
    }
    
}