<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class HomeController extends Controller
{
    public function index() {

    	// $user = Auth::user();
    	// dump($user);die;
    	return view('pages.frontend.home.index');

    }
}
