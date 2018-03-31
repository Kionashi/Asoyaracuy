<?php

namespace App\Models;

class ContactReason extends RDNModel
{
    public $timestamps = false;
    public $table = 'contact_reason';
    protected $fillable = ['title', 'enabled'];

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }
}
