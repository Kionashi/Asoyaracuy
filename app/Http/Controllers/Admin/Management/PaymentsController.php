<?php

namespace App\Http\Controllers\Admin\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\RDNAdminController;
use App\Models\Payment as PaymentModel;
use App\Enums\PaymentStatus;
use App\Models\OrganizationBalance;

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
    
    public function approve(Request $request, $id) {
        // Find payment
        $payment = PaymentModel::with('user')->find($id);
        if ($payment->status != PaymentStatus::APPROVED) {
            // Set status to approved
            $this->updateStatus($payment, PaymentStatus::APPROVED);
            
            // Update user balance
            $user = $payment->user;
            $user->balance += $payment->amount;
            $user->save();

            //Add to the organization balance
            OrganizationBalance::add($payment->amount);
            
            // Store audit
            $this->storeAudit('Aprobar pago ['. $payment->user->house.']', 'Pago aprobado por'.' para ' . $payment->user->house . ' por un monto de '. $payment->amount, $request->getClientIp());
        }
        
        // Redirect to list
        return redirect()->route('management/payments');
    }
    
    public function reject(Request $request, $id) {
        // Find payment
        $payment = PaymentModel::with('user')->find($id);
        
        // Set status to rejected
        $this->updateStatus($payment, PaymentStatus::REJECTED);
        
        // Store audit
        $this->storeAudit('Aprobar pago ['. $payment->user->house.']', 'Pago rechazado por para ' . $payment->user->house . ' por un monto de '. $payment->amount . ' por motivo ' . $payment->note, $request->getClientIp());
        
        // Redirect to list
        return redirect()->route('management/payments');
    }
    
    private function updateStatus($payment, $newStatus) {
        if ($payment) {
            // Update status
            $originalStatus = $payment->status;
            $payment->status = $newStatus;
            
            // Update payment
            $payment->save();
        }
    }

}
