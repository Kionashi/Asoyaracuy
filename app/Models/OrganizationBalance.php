<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationBalance extends RDNModel
{
	public $timestamps = true;
    public $table = 'organization_balance';
    protected $fillable = [
        'balance','status'
    ];

    public static function getBalance() {

        $active = organizationBalance::where('status','ACTIVE')
            ->first()
            ;

    	return $active;
    }
}
