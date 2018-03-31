<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Route;

class RDNAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Define public routes
        $publicRoutes = array (
            'logout',
            'sign-in',
            'password-recovery',
            'password-recovery/change-password',
            'password-recovery/message-password-changed',
            'sign-in/authenticate'
        );
        // Check if session contains auth information
        if (!in_array(Route::getCurrentRoute()->getName(), $publicRoutes)) {
            if(!$request->session()->has('admin.auth.admin-user.id')) {
                // Save requested url
                $requestedUrl = $request->fullUrl();
                $request->session()->put('admin.auth.requested-url', $requestedUrl);
                $request->session()->put('admin.auth.requested-route-name', Route::getCurrentRoute()->getName());
                
                // Redirect to admin login page
                return redirect()->route('sign-in');
            }
            else {
                // Get route name
                $requestedRouteName = $request->route()->getName();
                
                if($requestedRouteName != 'admin'){
                    $permissions = session()->get('admin.auth.admin-user.permissions');
                    
                    // Merge to get all permissions
                    $result=array();
                    foreach ($permissions as $permission){
                        $result=array_merge($result,$permission);
                    }
                    $permissions = $result;
                    
                    if(!in_array($requestedRouteName, $permissions)  ){
                        return response()->view('errors.admin.403');
                    }
                }
                
            }
        }
        
        // Access granted
        return $next($request);
    }

}
