<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\RDNAdminController;
use App\Models\OrganizationBalance;
class Dashboard extends RDNAdminController
{
    public function index()
    {
    	$organizationBalance = OrganizationBalance::getBalance();
    	if(!$organizationBalance){
    		$organizationBalance = 0;
    	}
        // Render administrator index view
        return $this->view('pages.admin.dashboard')
        	->with('organizationBalance',$organizationBalance)
        	;
    }
}
