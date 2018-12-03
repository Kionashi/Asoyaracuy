<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\RDNAdminController;
use App\Models\Collection;
use App\Models\Fee;
use App\Models\User;
use App\Models\SpecialFee;


class CollectionController extends RDNAdminController
{
    public function index(){

        $collection = Collection::getNewest();

    	if(!$collection){
    		$collection = new Collection();
    		$collection->date = date_create('15-06-1990');
    		$fee = new Fee();
    		$fee->amount = 0; 
    		$collection->fee = $fee;
    	}

    	return $this->view('pages.admin.collection')
    		->with('collection',$collection)
    		;
    }

    public function create(){

        $collection = Collection::getNewest();
    	$users = User::all();
        $fee = Fee::getCurrentFee();
        $feeAux = $fee;
        $date = date('Y-m-d', time());

    	foreach ($users as $user) {
    		if($user->specialFee){
                $fee = $user->specialFee;
            }
            $user->balance = $user->balance - $fee->amount;
            $user->save();
            $fee = $feeAux;
    	}

        if($collection){

            $collection->newest = false;
            $collection->save();
        }
        $newCollection = new Collection();
        $newCollection->date = $date; 
        $newCollection->fee_id = $fee->id;
        $newCollection->newest = true;
        $newCollection->save();

        return $this->index();
    }
}
