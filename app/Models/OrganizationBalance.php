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

    //Adds founds to the organization balance
    public static function add($amount){
        $organizationB = organizationBalance::where('status','ACTIVE')
            ->first()
            ;
        if(!$organizationB){
            $organizationB = new OrganizationBalance();
            $organizationB->balance = 0;
            $organizationB->status = 'ACTIVE';
        }
        $organizationB->balance = $organizationB->balance+$amount;
        $organizationB->save();

        return $organizationB->balance;
    }
}
