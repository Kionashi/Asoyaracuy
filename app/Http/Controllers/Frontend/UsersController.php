<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;

class UsersController extends Controller
{
	//Creates a demo user if the database is empty
	//Check all payments
    public function demo() {

    	$payments = Payment::all();
    	$users = User::all();

    	dump($users);
    	dump($payments);
    	die;
    }
}
