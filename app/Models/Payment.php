<?php

namespace App\Models;

class Payment extends RDNModel
{
    public $timestamps = true;
    public $table = 'payment';
    protected $fillable = ['amount', 'bank', 'confirmation_code', 'date', 'file', 'note', 'type', 'status'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
}
