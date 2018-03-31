<?php

namespace App\Models;

class Contact extends RDNModel
{
    public $timestamps = false;
    public $table = 'contact';
    protected $fillable = ['date_contact', 'email', 'first_name', 'ip_address', 'last_name', 'message', 'phone', 'contact_reason_id', 'user_id'];

    public function contactReason()
    {
        return $this->belongsTo('App\Models\ContactReason');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
