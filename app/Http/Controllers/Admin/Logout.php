<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\RDNAdminController;

class Logout extends RDNAdminController
{
	public function index(Request $request)
	{
		// Destroy session
		$request->session()->forget('admin.auth');
		
		// Redirect to login page
		return redirect()->route('sign-in');
	}
}
