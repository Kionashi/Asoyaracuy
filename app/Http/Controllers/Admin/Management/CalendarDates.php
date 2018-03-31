<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\RDNAdminController;
use App\Models\CalendarDate as CalendarDateModel;
use Illuminate\Http\Request;
use JsValidator;


class CalendarDates extends RDNAdminController
{
    /**
     * Define your validation messages in a property in
     * the controller to reuse the messages.
     */
    
    protected $validationMessages = [
        'required'  => 'Este campo es requerido',
        'unique'    => 'La fecha seleccionada no se encuentra disponible',
        
    ];
    protected $addValidationRules = array();
    protected $editValidationRules = array();
    protected $orderOptions = array();
    
    public function __construct() {
        parent::__construct();
        $this->addValidationRules['date'] = 'required|unique:calendar_date';

        $this->editValidationRules['date'] = 'required|unique:calendar_date';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return admin.calendar-dates.index
     */
    
    public function index()
    {
        // Load page size values
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Load paginator default value
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        
        // Add breadcrumbs
        $this->addBreadcrumb('Fechas', route('management/calendar-dates'));
        
        // Set Title and subtitle
        $this->title = 'Fechas';
        
        // Find all calendar dates
        $calendarDates = CalendarDateModel::all();
        
        // Display view
        return $this->view('pages.admin.management.calendar-dates.index')
            ->with('calendarDates', $calendarDates)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes);
        ;
    }

    /**
     * Show the form for adding a new resource.
     *
     * @return admin.calendar-dates.add
     */
    public function add()
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Fechas', route('management/calendar-dates'));
        $this->addBreadcrumb('Agregar', route('management/calendar-dates/add'));
    
        // Set Title and subtitle
        $this->title = 'Fechas';
        $this->subtitle = 'agregar nueva entrada';
    
        // Create new calendar date
        $calendarDate = new CalendarDateModel();
    
        // Prepare view data
        $validator = JsValidator::make($this->addValidationRules, $this->validationMessages, [], "#addACalendarDateForm")->view('pages.admin.validations.validation-with-tabs');

        // Display view
        return $this->view('pages.admin.management.calendar-dates.add')
            ->with('calendarDate', $calendarDate)
            ->with('validator', $validator)
        ;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @redirect admin.calendar-dates
     */
    public function delete($id)
    {
        // Load calendar date
        $calendarDate = CalendarDateModel::with('blogEntries')
            ->with('events')
            ->with('indicatorValues')
            ->with('newsAlerts')
            ->with('newsDigests')
            ->find($id)
        ;
         
        // Remove if not empty
        if(!empty($calendarDate)){
            try {
                // Check if calendar date has blog entries assigned
                if($calendarDate->blogEntryCount) {
                    // Redirect with errors
                    $errors = array('message' => 'No se puede eliminar la fecha #' .$id. ' porque está asignada a una entrada de una columna');
                    return redirect()->route('management/calendar-dates')->withErrors($errors);
                }
                
                // Check if calendar date has contact assigned
                if($calendarDate->contactCount) {
                    // Redirect with errors
                    $errors = array('message' => 'No se puede eliminar la fecha #' .$id. ' porque está asignada a un contacto');
                    return redirect()->route('management/calendar-dates')->withErrors($errors);
                }
                
                // Check if calendar date has events assigned
                if($calendarDate->eventCount) {
                    // Redirect with errors
                    $errors = array('message' => 'No se puede eliminar la fecha #' .$id. ' porque está asignada a una efeméride');
                    return redirect()->route('management/calendar-dates')->withErrors($errors);
                }
                
                // Check if calendar date has indicator values assigned
                if($calendarDate->indicatorValuesCount) {
                    // Redirect with errors
                    $errors = array('message' => 'No se puede eliminar la fecha #' .$id. ' porque está asignada a un valor de un indicador');
                    return redirect()->route('management/calendar-dates')->withErrors($errors);
                }
                
                // Check if calendar date has news digests assigned
                if($calendarDate->newsDigestsCount) {
                    // Redirect with errors
                    $errors = array('message' => 'No se puede eliminar la fecha #' .$id. ' porque está asignada a un resumen de noticia');
                    return redirect()->route('management/calendar-dates')->withErrors($errors);
                }
                
                // Remove from database
                CalendarDateModel::destroy($id);
            } catch(\Exception $e){
                $errors = array('message' => 'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde');
                return redirect()->route('management/calendar-dates')->withErrors($errors);
            }            
        }
        
        // Redirect to calendar date list
        return redirect()->route('management/calendar-dates');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return admin.calendar-dates.detail
     */
    public function detail($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Fechas', route('management/calendar-dates'));
        $this->addBreadcrumb('Detalle', route('management/calendar-dates/detail',$id));
        
        // Set Title and subtitle
        $this->title = 'Fechas';
        $this->subtitle = 'entrada #'.$id;
        
        // Find calendar date by id
        $calendarDate = CalendarDateModel::find($id);
        
        if ($calendarDate) {
            // Display view
            return $this->view('pages.admin.management.calendar-dates.detail')
                ->with('calendarDate', $calendarDate)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
         
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return admin.calendar-dates.edit
     */
    public function edit($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Fechas', route('management/calendar-dates'));
        $this->addBreadcrumb('Editar', route('management/calendar-dates/edit',$id));
        
        // Set Title and subtitle
        $this->title = 'Fechas';
        $this->subtitle = 'editar entrada #'.$id;
        
        // Load calendar date
        $calendarDate = CalendarDateModel::find($id);
        
        if($calendarDate){
            // Prepare view data
            $editValidator = JsValidator::make($this->editValidationRules, $this->validationMessages, [], "#editCalendarDateForm")->view('pages.admin.validations.validation-with-tabs');
        
            // Display view
            return $this->view('pages.admin.management.calendar-dates.edit')
                ->with('editValidator', $editValidator)
                ->with('calendarDate', $calendarDate)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return admin.calendar-dates.add
     */
    public function store(Request $request)
    {
        // Get values
        $values = $request->all();
    
        // Validate
        $this->validate($request, $this->addValidationRules, $this->validationMessages);
         
        // Create new calendar date
        $calendarDate = new CalendarDateModel();
        $calendarDate->date = $values['date'];
    
        // Store in database
        $calendarDate->save();
        
        return redirect()->route('management/calendar-dates');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return admin.calendar-dates.edit
     */
    public function update(Request $request, $id)
    {
        // Get values
        $values = $request->all();
    
        // Validate
        $this->editValidationRules['date'] = "required|unique:calendar_date,date,".$request->id;
        $this->validate($request, $this->editValidationRules, $this->validationMessages);
         
        // Load calendar date
        $calendarDate = CalendarDateModel::find($id);
        $calendarDate->date = $values['date'];
        
        // Update in database
        $calendarDate->save();
    
        return redirect()->route('management/calendar-dates');
    }

}
