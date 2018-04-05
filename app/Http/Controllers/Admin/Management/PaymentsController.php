<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\RDNAdminController;
use App\Models\Payment as PaymentModel;
use App\Enum\PaymentStatus;

class PaymentsController extends RDNAdminController
{
    public function index() {
        // Load page size values
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Load paginator default value
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        
        // Add breadcrumbs
        $this->addBreadcrumb('Pagos', route('management/payments'));
        
        // Set Title and subtitle
        $this->title = 'Pagos';
        
        // Find all audits
        $payments = PaymentModel::with('user')->get();
        
        // Display view
        return $this->view('pages.admin.management.payments.index')
            ->with('payments', $payments)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes);
        ;
    }
    
    public function detail($id) {
        // Add breadcrumbs
        $this->addBreadcrumb('Pagos', route('management/payments'));
        $this->addBreadcrumb('Detalle', route('management/payments/detail',$id));
        
        // Set Title and subtitle
        $this->title = 'Pagos';
        $this->subtitle = 'entrada #'.$id;
        
        $payment = PaymentModel::with('user')->find($id);
        
        return $this->view('pages.admin.management.payments.detail')
            ->with('payment', $payment)
        ;
    }
    
    public function approve($id) {
        // Set status to approved
        $this->updateStatus($id, PaymentStatus::APPROVED);
    }
    
    public function reject($id) {
        // Set status to rejected
        $this->updateStatus($id, PaymentStatus::REJECTED);
    }
    
    private function updateStatus($id, $newStatus) {
        // Find payment
        $payment = PaymentModel::find($id);
        if ($payment) {
            // Update status
            $originalStatus = $payment->status;
            $payment->status = $newStatus;
            
            // Update payment
            $payment->save();
            
            // Manage user balance
//             switch($newStatus) {
//                 case PaymentStatus::APPROVED
//             }
        }
    }

}
