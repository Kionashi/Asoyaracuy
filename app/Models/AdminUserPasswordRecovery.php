<?php

namespace App\Models;

class AdminUserPasswordRecovery extends RDNModel
{
	public $timestamps = false;
	public $table = 'admin_user_password_recovery';
	protected $fillable = ['code', 'creation_date', 'creation_ip_address', 'status', 'usage_date', 'usage_ip_address', 'admin_user_id'];
    
    public function adminUser()
    {
    	return $this->belongsTo('App\Models\AdminUser');
    }
    
}