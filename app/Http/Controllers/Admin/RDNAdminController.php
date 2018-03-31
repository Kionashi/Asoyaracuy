<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\RDNController as RDNController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\AdminUser;
use App\Models\ConfigItem;
use stdClass;

class RDNAdminController extends RDNController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $breadcrumbs = array();
    protected $configItems = array();
    protected $subtitle = '';
    protected $title = '';
    
    function __construct()
    {
        // Load config items
        $this->configItems = ConfigItem::listConfigItems();
    }
    
    function addBreadcrumb($title, $url, $icon=null)
    {
        // Create new breadcrumb
        $breadcrumb = new stdClass();
        $breadcrumb->title = $title;
        $breadcrumb->url = $url;
        $breadcrumb->icon = $icon;
    
        // Add breadcrumb to array
        $this->breadcrumbs[] = $breadcrumb;
    }
    
    function view($view = null, $data = [], $mergeData = [])
    {
        return view($view, $data, $mergeData)
        ->with('breadcrumbs', $this->breadcrumbs)
        ->with('subtitle', $this->subtitle)
        ->with('title', $this->title)
        ;
    }
    
    function storeAudit($action, $details, $ip) {
        
        // Create audit
        $audit = new Audit();
        $audit->action = $action;
        $audit->details = $details;
        $audit->ip_address = $ip;
        $audit->admin_user_id = session()->get('admin.auth.admin-user.id');
        
        // Store audit
        $audit->save();
        
    }
    
}
