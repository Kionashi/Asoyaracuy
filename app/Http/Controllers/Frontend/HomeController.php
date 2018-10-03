<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
class HomeController extends Controller
{
    public function index() {

    	$user = Auth::user();

    	//If the user is logged send it to the index page, else it will be sent to the login page
    	if($user) {
    		return view('pages.frontend.home.index')
    			->with('user',$user)
    			;
    	}else{
    		return view('pages.frontend.home.login');
    	}


    }
}
