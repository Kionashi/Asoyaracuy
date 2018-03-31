<?php

namespace App\Http\Controllers\Admin\Management;

use App\Models\StaticContent as StaticContentModel;
use App;
use App\Enums\StaticContentSection;
use App\Http\Controllers\Admin\RDNAdminController;
use Illuminate\Http\Request;
use JsValidator;
use Illuminate\Support\Facades\Input;

class StaticContents extends RDNAdminController
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
     * @return admin.static-contents.index
     */    
    protected $addValidationRules = array();
    protected $editValidationRules = array();
    
    public function __construct() {
        parent::__construct();
            $this->addValidationRules['content'] = 'required';
            $this->addValidationRules['section'] = 'required';
            $this->editValidationRules['content'] = 'required';
            $this->editValidationRules['section'] = 'required';
    }
    
    public function index()
    {
        // Load page configuration values
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Add breadcrumbs
        $this->addBreadcrumb('Contenidos estáticos', route('management/static-contents'));
        
        // Set Title and subtitle
        $this->title = 'Contenidos estáticos';
        
        // Find all static-contents
        $staticContents = StaticContentModel::all();
        
        // Display view
        return $this->view('pages.admin.management.static-contents.index')
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes)
            ->with('staticContents', $staticContents)
        ;
    }

    /**
     * Show the form for adding a new resource.
     *
     * @return admin.static-contents.add
     */
    public function add()
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Contenido estático', route('management/static-contents'));
        $this->addBreadcrumb('Agregar', route('management/static-contents/add'));
            
        // Set Title and subtitle
        $this->title = 'Contenidos estáticos';
        $this->subtitle = 'agregar nueva entrada';
            
        // Create new static-content
        $staticContent = new StaticContentModel();
        
        $sections = StaticContentSection::values();
        
        // Prepare view data
        $validator = JsValidator::make($this->addValidationRules, $this->validationMessages, [], "#addStaticContentForm")->view('pages.admin.validations.validation-with-tabs');
        
        // Display view
        return $this->view('pages.admin.management.static-contents.add')
            ->with('staticContent', $staticContent)
            ->with('sections', $sections)
            ->with('validator', $validator)
            
        ;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @redirect admin.static-contents
     */
    public function delete($id)
    {
        try {
            // Try to delete indicator
            StaticContentModel::destroy($id);
            
            // Return to index page
            return redirect()->route('management/static-contents');
             
        } catch(\Exception $e){
            // Catch exception and return error
            $errors = array('message' => 'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde');
            return redirect()->route('management/static-contents')->withErrors($errors);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return admin.static-contents.detail
     */
    public function detail($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Contenidos estáticos', route('management/static-contents'));
        $this->addBreadcrumb('Detalle', route('management/static-contents/detail',$id));
         
        // Set Title and subtitle
        $this->title = 'Contenido estático';
        $this->subtitle = 'entrada #'.$id;
        
        // Find static-content by id
        $staticContent = StaticContentModel::find($id);
        
        if($staticContent){
            // Display view
            return $this->view('pages.admin.management.static-contents.detail')
                ->with('staticContent', $staticContent)
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
     * @return admin.static-contents.edit
     */
    public function edit($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Contenidos estáticos', route('management/static-contents'));
        $this->addBreadcrumb('Editar', route('management/static-contents/edit',$id));
        
        // Set Title and subtitle
        $this->title = 'Contenido estático';
        $this->subtitle = 'editar entrada #'.$id;
        
        // Find static-content by id
        $staticContent = StaticContentModel::find($id);
        
        $sections = StaticContentSection::values();
        
        if($staticContent){
            // Prepare view data
            $editValidator = JsValidator::make($this->editValidationRules, $this->validationMessages, [], "#editStaticContentForm")->view('pages.admin.validations.validation-with-tabs');
            
            // Display view
            return $this->view('pages.admin.management.static-contents.edit')
                ->with('editValidator', $editValidator)
                ->with('sections', $sections)
                ->with('staticContent', $staticContent)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return admin.static-contents.add
     */
    public function store(Request $request)
    {    
        // Get values
        $values = $request->all();
        // Validate
        $this->validate($request, $this->addValidationRules, $this->validationMessages);
        
        // Create new static-content
        $staticContent = new StaticContentModel();
        $staticContent->content = $values['content'];
        $staticContent->section = $values['section'];
        
        // Set enabled
        if (isset($values['enabled'])) {
            $staticContent->enabled = true;
        } else {
            $staticContent->enabled = false;
        }
        
        $sameSection = StaticContentModel::where('section', $values['section'])->where('enabled', true)->first();
        if($sameSection && $staticContent->enabled) {
            // Catch exception and return error
            $errors = array('message' => 'Ya existe un contenido estático habilitado para la sección seleccionada');
            return redirect()->route('management/static-contents/add')->withErrors($errors)->withInput(Input::all());
        }
        
        // Store in database
        $staticContent->save();
        
        // Redirect to indicators list
        return redirect()->route('management/static-contents');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return admin.static-contents.edit
     */
    public function update(Request $request, $id)
    {
        // Get values
        $values = $request->all();
        
        // Validate
        $this->validate($request, $this->editValidationRules, $this->validationMessages);
        
        // Load static-content
        $staticContent = StaticContentModel::find($id);
        if($staticContent){
            // Update indicator values
            $staticContent->content = $values['content'];
            $staticContent->section = $values['section'];
            
            // Set enabled
            if (isset($values['enabled'])) {
                $staticContent->enabled = true;
            } else {
                $staticContent->enabled = false;
            }
            
            // Validate section
            $sameSection = StaticContentModel::where('section', $values['section'])->where('enabled', true)->first();
            if($sameSection && $staticContent->enabled && $sameSection->id != $staticContent->id) {
                // Catch exception and return error
                $errors = array('message' => 'Ya existe un contenido estático habilitado para la sección seleccionada');
                return redirect()->route('management/static-contents/edit', $staticContent->id)->withErrors($errors)->withInput(Input::all());
            }
            
            // Update in database
            $staticContent->save();
            
             // Redirect to indicators list
            return redirect()->route('management/static-contents');
        }else{
            return response()->view('errors.admin.404');
        }
    }
    
}
