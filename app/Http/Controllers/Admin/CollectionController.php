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

    	$users = User::all();

    	foreach ($users as $user) {
    		echo($user->specialFee);
    	}
    	die;
    }
}
