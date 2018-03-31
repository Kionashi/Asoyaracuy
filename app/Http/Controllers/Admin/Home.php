<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\RDNAdminController;

class Home extends RDNAdminController
{
    public function index()
    {
        // Render administrator index view
        return $this->view('pages.admin.home.index');
    }
}
