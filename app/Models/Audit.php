<?php

namespace App\Models;

class Audit extends RDNModel
{
    public $timestamps = true;
    public $table = 'audit';
    protected $fillable = ['ip_address', 'action', 'details', 'admin_user_id'];
    
    public function adminUser()
    {
        return $this->belongsTo('App\Models\AdminUser');
    }
}
