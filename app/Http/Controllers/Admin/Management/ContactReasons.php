<?php

namespace App\Http\Controllers\Admin\Management;

use App\Helpers\Admin\AdminAuthHelper;
use App\Models\Contact as ContactModel;
use App\Models\ContactReason as ContactReasonModel;
use App;
use App\Http\Controllers\Admin\RDNAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use JsValidator;

class ContactReasons extends RDNAdminController
{
       /**
     * Define your validation messages in a property in
     * the controller to reuse the messages.
     */
    
    protected $validationMessages = [
        'required'      => 'Este campo es requerido',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return admin.carousel-items.index
     */    
    protected $addValidationRules = array();
    protected $editValidationRules = array();
    protected $changePasswordValidationRules = array();
    
    public function __construct() {
        parent::__construct();
            $this->addValidationRules['title'] = 'required';
            $this->editValidationRules['title'] = 'required';
    }
    
    public function index()
    {
        // Load page configuration values
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Add breadcrumbs
        $this->addBreadcrumb('Razones de contacto', route('management/contact-reasons'));
        
        // Set Title and subtitle
        $this->title = 'Razones de contacto';
        
        // Get session user
        $sessionUser = $permissions = session()->get('admin.auth.admin-user');
        
        // Find all contact reasons
        $contactReasons = ContactReasonModel::all();
        
        // Display view
        return $this->view('pages.admin.management.contact-reasons.index')
            ->with('contactReasons', $contactReasons)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes)
        ;
    }

    /**
     * Show the form for adding a new resource.
     *
     * @return admin.contact-reasons.add
     */
    public function add()
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Razón de contacto', route('management/contact-reasons'));
        $this->addBreadcrumb('Agregar', route('management/contact-reasons/add'));
            
        // Set Title and subtitle
        $this->title = 'Razones de contacto';
        $this->subtitle = 'agregar nueva entrada';
            
        // Create new admin user
        $contactReason = new ContactReasonModel();
        $types = array();
        
        // Prepare view data
        $validator = JsValidator::make($this->addValidationRules, $this->validationMessages, [], "#addContactReasonForm")->view('pages.admin.validations.validation-with-tabs');
        
        // Display view
        return $this->view('pages.admin.management.contact-reasons.add')
            ->with('contactReason', $contactReason)
            ->with('validator', $validator)
        ;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @redirect admin.contact-reasons
     */
    public function delete($id)
    {
        // Load contacts who use this contact reason
        $contacts = ContactModel::where('contact_reason_id', $id)->first();
        
        // Remove if not empty
        if($contacts != null){
            // Redirect with errors
            $errors = array('message' => 'No se pudo eliminar la entrada #' .$id. ' porque ya está siendo usada en un contacto');
            return redirect()->route('management/contact-reasons')->withErrors($errors);
        } else {
            try {
                // Try to delete contact reason
                ContactReasonModel::destroy($id);
                
                // Return to index page
                return redirect()->route('management/contact-reasons');
                 
            } catch(\Exception $e){
                // Catch exception and return error
                $errors = array('message' => 'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde');
                return redirect()->route('management/contact-reasons')->withErrors($errors);
            }
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return admin.contact-reasons.detail
     */
    public function detail($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Razones de contacto', route('management/contact-reasons'));
        $this->addBreadcrumb('Detalle', route('management/contact-reasons/detail',$id));
         
        // Set Title and subtitle
        $this->title = 'Razón de contacto';
        $this->subtitle = 'entrada #'.$id;
        
        // Find contact reason by id
        $contactReason = ContactReasonModel::find($id);
        
        if($contactReason){
            // Display view
            return $this->view('pages.admin.management.contact-reasons.detail')
                ->with('contactReason', $contactReason)
            ;
        } else {
            // Redirect to page not found error 404
            return response()->view('errors.admin.404');
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return admin.contact-reasons.edit
     */
    public function edit($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Razones de contacto', route('management/contact-reasons'));
        $this->addBreadcrumb('Editar', route('management/contact-reasons/edit',$id));
        
        // Set Title and subtitle
        $this->title = 'Razón de contacto';
        $this->subtitle = 'editar entrada #'.$id;
        
        // Find contact reason by id
        $contactReason = ContactReasonModel::find($id);
        
        if($contactReason){
            // Prepare view data
            $editValidator = JsValidator::make($this->editValidationRules, $this->validationMessages, [], "#editContactReasonForm")->view('pages.admin.validations.validation-with-tabs');
        
            // Display view
            return $this->view('pages.admin.management.contact-reasons.edit')
                ->with('contactReason', $contactReason)
                ->with('editValidator', $editValidator)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return admin.contact-reasons.add
     */
    public function store(Request $request)
    {    
        // Get values
        $values = $request->all();
        
        // Validate
        $this->validate($request, $this->addValidationRules, $this->validationMessages);
            
        // Create new admin user item
        $contactReason = new ContactReasonModel();
        $contactReason->title = $values['title'];
        
        // Set enabled
        if (isset($values['enabled'])) {
            $contactReason->enabled = true;
        } else {
            $contactReason->enabled = false;
        }
        
        // Store in database
        $contactReason->save();
        
        // Redirect to admin users list
        return redirect()->route('management/contact-reasons');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return admin.contact-reasons.edit
     */
    public function update(Request $request, $id)
    {
        // Get values
        $values = $request->all();
        
        // Validate
        $this->validate($request, $this->editValidationRules, $this->validationMessages);
        
        // Load contact reason
        $contactReason = ContactReasonModel::find($id);
        if($contactReason){
            // Update contact reason values
            $contactReason->title = $values['title'];
            
            // Set enabled
            if (isset($values['enabled'])) {
                $contactReason->enabled = true;
            } else {
                $contactReason->enabled = false;
            }
            
            // Update in database
            $contactReason->save();
            
             // Redirect to admin users list
            return redirect()->route('management/contact-reasons');
        }else{
            return response()->view('errors.admin.404');
        }
    }
    
}
