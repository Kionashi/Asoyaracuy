<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrganizationBalance;

class Operation extends RDNModel
{
    protected $fillable = [
        'amount', 'concept', 'details','type'
    ];
    
    public static function add($amount, $concept, $details,$type) {
    	
    	$operation = new Operation();
    	$operation->amount = $amount;
    	$operation->concept = $concept;
    	$operation->details = $details;
    	$operation->save();
    	
	 	//Create a new Organization balance and disabling the old balance
        $organizationBalance = OrganizationBalance::where('status','ACTIVE')->first();
        $newBalance = new OrganizationBalance();
        if($type == 'INCOME'){
        	$newBalance->balance = $organizationBalance + $operation->amount;
        }elseif ($type == 'EXPENSE') {
        	$newBalance->balance = $organizationBalance - $operation->amount;
        }
        $organizationBalance->status = 'INACTIVE';
        $newBalance->status = 'ACTIVE';
        $organizationBalance->save();
        $newBalance->save();
        
        return $operation;
    }
    
    public static function edit($amount, $concept, $details,$type, $id) {
    	
    	$operation = Operation::find($id);
    	$operationBackup = Operation::find($id);
    	
    	$currentBalance = OrganizationBalance::where('status','ACTIVE')->first();
    	if($type == 'INCOME'){
    		$currentBalance->balance = $currentBalance->balance - $operation->amount + $amount;
    		
        }elseif ($type == 'EXPENSE') {
    		$currentBalance->balance = $currentBalance->balance + $operation->amount - $amount;
        }
    	$currentBalance->save();
    	
    	$operation->amount = $amount;
    	$operation->concept = $concept;
    	$operation->details = $details;
    	$operation->save();
    	
    	return $operationBackup;
   
    }
}
