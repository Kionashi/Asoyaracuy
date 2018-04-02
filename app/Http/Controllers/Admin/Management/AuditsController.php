<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\RDNAdminController;
use App\Models\Audit as AuditModel;

class AuditsController extends RDNAdminController
{
    public function index()
    {
        // Load page size values
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Load paginator default value
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        
        // Add breadcrumbs
        $this->addBreadcrumb('Auditorias', route('audits'));
        
        // Set Title and subtitle
        $this->title = 'Auditorias';
        
        // Find all audits
        $audits = AuditModel::with('adminUser')->get();
        
        // Display view
        return $this->view('pages.admin.management.audits.index')
            ->with('audits', $audits)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes);
        ;
    }
    
    public function detail($id) {
        
        // Add breadcrumbs
        $this->addBreadcrumb('Auditorias', route('audits'));
        $this->addBreadcrumb('Detalle', route('audits/detail',$id));
        
        // Set Title and subtitle
        $this->title = 'Auditoria';
        $this->subtitle = 'entrada #'.$id;
        
        $audit = AuditModel::with('adminUser')->find($id);
        
        return $this->view('pages.admin.management.audits.detail')
            ->with('audit', $audit)
        ;
    }

}
