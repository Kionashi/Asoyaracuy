<?php

namespace App\Helpers\Admin;

use Illuminate\Support\Facades\Request;

class AdminRouteHelper
{	
	
	public static function getSidebarClass($route) {
		return AdminRouteHelper::isActive($route) ? 'active':'';
	}
	
	private static function isActive($route) {
		$currentRoute = Request::route()->getName();
		
		return starts_with($currentRoute, $route);
	}
	
}

