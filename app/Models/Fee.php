<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
	public $timestamps = true;
    public $table = 'fee';
    protected $fillable = ['amount', 'current'];


    public static function getCurrentFee(){

    	$fee = Fee::where('current',true)
    		->first()
    		;
    	return $fee;

    }

    public static function deleteCurrent(){
    	$fee = Fee::getCurrentFee();
    	if($fee){
            $fee->current = false;
        	$fee->save();
        } 

    	return $fee;
    }

}
