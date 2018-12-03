<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\RDNAdminController;
use Illuminate\Http\Request;
use JsValidator;
use App\Models\SpecialFee;
use App\Models\User;

class SpecialFeeController extends RDNAdminController
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
    
    public function __construct() {
        parent::__construct();
        $this->addValidationRules['balance'] = 'required|numeric';
        $this->addValidationRules['email'] = 'required|email|unique:user,email';
        $this->addValidationRules['password'] = 'required';
        $this->addValidationRules['passwordConfirmation'] = 'required_with:password|same:password';
        $this->addValidationRules['phone'] = 'nullable|numeric';
        $this->addValidationRules['house'] = 'required|unique:user,house';
        
        $this->editValidationRules['balance'] = 'required|numeric';
        $this->editValidationRules['email'] = 'required|email|unique:user,email';
        $this->editValidationRules['phone'] = 'nullable|numeric';
        $this->editValidationRules['house'] = 'required|unique:user,house';
        
        $this->changePasswordValidationRules['password'] = 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
        $this->changePasswordValidationRules['passwordConfirmation'] = 'required_with:password|same:password';
    }
    
    public function index() {
        // Load page size values
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Load paginator default value
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        
        // Add breadcrumbs
        $this->addBreadcrumb('Cuotas Especiales', route('management/special-fees'));
        
        // Set Title and subtitle
        $this->title = 'Cuotas Especiales';
        
        // Find all specialFees
        $specialFees = SpecialFee::where('enabled',true)
            ->with('user')
            ->get()
            ;
        
        // Display view
        return $this->view('pages.admin.management.special-fees.index')
            ->with('specialFees', $specialFees)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes)
        ;
    }
    
    public function create($userId) {
        // Add breadcrumbs
        $this->addBreadcrumb('Cuotas especiales', route('management/special-fees'));
        
        // Set Title and subtitle
        $this->title = 'Cuotas especiales';
        $specialFee = SpecialFee::getCurrent($userId);

        if(!$specialFee) {
            $specialFee = new SpecialFee();
        }
        $user = User::find($userId);

        return $this->view('pages.admin.management.special-fees.create')
            ->with('user', $user)
            ->with('specialFee',$specialFee)
        ;
    }

    public function store(Request $request){

        $userId = $request->userId;
        $amount = $request->amount;
        $oldSpecialFee = SpecialFee::getCurrent($userId);
        $user = User::find($userId);

        $specialFee = new SpecialFee();
        $specialFee->amount = $amount;
        $specialFee->enabled = true;
        $specialFee->user_id = $userId;
        
        if($oldSpecialFee){
            $oldSpecialFee->enabled = false;
            $oldSpecialFee->save();
        }

        $specialFee->save();

        if($oldSpecialFee){
            // Store audit
            $this->storeAudit('Editar cuota especial ['. $user->house.']', 'La Cuota especial original (' . $oldSpecialFee->amount.') fue modificada a la cantidad de: '.$specialFee->amount, $request->getClientIp());
        }else{
            $this->storeAudit('Agregar cuota especial ['. $user->house.']', 'Creada cuota especial por el monto de ' . $specialFee->amount, $request->getClientIp());
        }

        return $this->index();
    }

    public function delete($id, Request $request){

        $specialFee = SpecialFee::find($id);
        $user = User::find($specialFee->user_id);
        $specialFee->delete();
        $this->storeAudit('Borrar cuota especial ['. $user->house.']', 'Borrada cuota especial con el monto de ' . $specialFee->amount, $request->getClientIp());

        return $this->index();
    }

}
