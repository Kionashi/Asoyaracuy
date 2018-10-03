<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\RDNAdminController;
use Illuminate\Http\Request;
use JsValidator;
use App\Models\Fee;

class FeesController extends RDNAdminController
{
    /**
     * Define your validation messages in a property in
     * the controller to reuse the messages.
     */
    
    protected $validationMessages = [
        'email'             => 'Debe introducir un correo electrónico válido',
        'email.unique'      => 'El correo electrónico ingresado no se encuentra disponible',
        'min'               => 'La contraseña de tener al menos 8 caracteres',
        'numeric'           => 'Este campo debe contener solo números',
        'regex'             => 'La contraseña de tener al menos 8 caracteres, una mayúscula y una minúscula y un caracter especial',
        'required'          => 'Este campo es requerido',
        'required_with'     => 'Este campo es requerido',
        'same'              => 'Las contraseñas deben coincidir',
        'username.unique'   => 'El nombre de usuario ingresado no se encuentra disponible',
    ];
    protected $addValidationRules = array();
    protected $editValidationRules = array();
    
    
    public function index() {
        // Load page size values
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Load paginator default value
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        
        // Add breadcrumbs
        $this->addBreadcrumb('Cuotas', route('management/fees'));
        
        // Set Title and subtitle
        $this->title = 'Cuotas';
        
        // Find current Fee
        $fee = Fee::getCurrentFee();
        if(!$fee){
            
            $fee = new Fee();
            $fee->amount = 0;
        }
        
        // Display view
        return $this->view('pages.admin.management.fees.index')
            ->with('fee', $fee)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes)
        ;
    }
    
    public function create(Request $request) {

        // dump($request);

        // dump($request->session);die;
        $amount = $request->amount;
        $oldfee = Fee::deleteCurrent();

        $fee = new Fee();
        $fee->amount = $amount;
        $fee->current = true; 
        $fee->save();


        return $this->index();
    }

}
