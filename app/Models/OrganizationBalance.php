<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationBalance extends RDNModel
{
    protected $fillable = [
        'balance','status'
    ];
}
