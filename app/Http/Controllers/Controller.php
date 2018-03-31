<?php

namespace App\Http\Controllers;

use App\Models\ConfigItem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $configItems = array();
    public $successStatus = 200;
    
    function __construct()
    {
        // Load config items
        $this->configItems = ConfigItem::listConfigItems();
    }
}
