<?php

namespace App\Models;

class StaticContent extends RDNModel
{
    public $timestamps = false;
    public $table = 'static_content';
    protected $fillable = ['content', 'enabled', 'section'];
    
}
