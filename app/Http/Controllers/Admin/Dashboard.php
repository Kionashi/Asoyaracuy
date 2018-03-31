<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\RDNAdminController;

class Dashboard extends RDNAdminController
{
    public function index()
    {
        // Render administrator index view
        return $this->view('pages.admin.dashboard');
    }
}
