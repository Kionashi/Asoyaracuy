<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use JsValidator;
use App\Models\AdminUser;
use App\Helpers\Admin\AdminAuthHelper;

class SignIn extends RDNAdminController
{
    protected $authenticationValidateRules = [
    	'email' => 'email|required',
    	'password' => 'required',
    ];
	
	public function index(Request $request)
   	{
   		// If already signed in, redirect to account
   		if($request->session()->has('admin.auth.admin-user.id')) {
   			return redirect()->route('admin');
   		}
   		 
   		// Create admin user validator
   		$validator = JsValidator::make($this->authenticationValidateRules, [], [], '#sign-in-form');
   		
   		return $this->view('pages.admin.sign-in.index')
   			->with('validator', $validator)
   		;
	}
	
	public function authenticate(Request $request)
	{
		$parameters = $request->all();
		
		// Get request parameters
		$email = $parameters['email'];
		$password = $parameters['password'];
		
		// Authenticate user
		$adminUser = AdminUser::authenticate($email, $password);

		// Initialize the array of permissions
		$adminUserPermissions = array();
		
		if($adminUser){
	
			// Load all adminUser Roles to generater adminUserPermissions array
			foreach($adminUser->enabledRoles() as $adminUserRole){
				foreach ($adminUserRole->enabledPermissions() as $permission){
					if(isset($adminUserPermissions[$permission->adminUserType])){
						array_push($adminUserPermissions[$permission->adminUserType], $permission->url);
					}else{
						$adminUserPermissions[$permission->adminUserType] = array();
						array_push($adminUserPermissions[$permission->adminUserType], $permission->url);
					}
				}
			}
			
			// Put admin user data on session
			session()->put('admin.auth.admin-user.id', $adminUser->id);
			session()->put('admin.auth.admin-user.firstName', $adminUser->firstName);
			session()->put('admin.auth.admin-user.lastName', $adminUser->lastName);
			session()->put('admin.auth.admin-user.email', $adminUser->email);
			session()->put('admin.auth.admin-user.type', $adminUser->type);
			// Load on session the admin user permissions
			session()->put('admin.auth.admin-user.permissions', $adminUserPermissions);
			
			// If user requested an url, redirect
			if($request->session()->has('admin.auth.requested-url')) {
				
				// If the user has permision of dashboard
				if($request->session()->get('admin.auth.requested-route-name') == 'admin' && AdminAuthHelper::hasPermission('dashboard')){
					return redirect()->route('dashboard');
				}
				
				// Redirect to requested url
				return redirect($request->session()->get('admin.auth.requested-url'));
			}
			
			// If user has permission to visit dashboard
			if(AdminAuthHelper::hasPermission('dashboard')){
				return redirect()->route('dashboard');
			}
			// Redirect to admin
			return redirect()->route('admin');
			
		}else{
			session()->flash('error-message', 'Username and password do not match.');			
			return redirect()->back()->withInput();
			
		}
	}
}
