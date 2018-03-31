<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\RDNAdminController;
use App\Helpers\Admin\AdminUploadFileHelper;
use App\Models\Poll as PollModel;
use App\Models\PollOption as PollOptionModel;
use App\Models\UserHasPollOption as UserHasPollOptionModel;
use Illuminate\Http\Request;
use JsValidator;
use function GuzzleHttp\json_encode;


class Polls extends RDNAdminController
{
    const FOLDER_NAME = 'poll/';
    
    /**
     * Define your validation messages in a property in
     * the controller to reuse the messages.
     */
    
    protected $validationMessages = [
        'dimensions'    => 'La imagen tiene dimensiones no válidas',
        'image'         => 'El archivo  debe ser una imagen',
        'required'      => 'Este campo es requerido',
        'after'         => 'La fecha de fin debe ser anterior a la fecha de inicio'
        
    ];
    protected $addValidationRules = array();
    protected $editValidationRules = array();
    protected $orderOptions = array();
    
    public function __construct() {
        parent::__construct();
        $this->addValidationRules['endDate'] = 'required|after:startDate';
        $this->addValidationRules['image'] = 'required|image';
        $this->addValidationRules['startDate'] = 'required';
        $this->addValidationRules['title'] = 'required';
//         $this->addValidationRules['options.*.title'] = 'required';
//         $this->addValidationRules['options.*.color'] = 'required';
        
        $this->editValidationRules['endDate'] = 'required|after:startDate';
        $this->editValidationRules['image'] = 'image';
        $this->editValidationRules['startDate'] = 'required';
        $this->editValidationRules['title'] = 'required';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return admin.polls.index
     */
    
    public function index()
    {
        // Load page size values
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Load paginator default value
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        
        // Add breadcrumbs
        $this->addBreadcrumb('Encuestas', route('management/polls'));
        
        // Set Title and subtitle
        $this->title = 'Encuestas';
        
        // Find all polls
        $polls = PollModel::all();
        
        // Display view
        return $this->view('pages.admin.management.polls.index')
            ->with('polls', $polls)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes);
        ;
    }

    /**
     * Show the form for adding a new resource.
     *
     * @return admin.polls.add
     */
    public function add()
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Encuestas', route('management/polls'));
        $this->addBreadcrumb('Agregar', route('management/polls/add'));
    
        // Set Title and subtitle
        $this->title = 'Encuesta';
        $this->subtitle = 'agregar nueva entrada';
    
        // Create new poll
        $poll = new PollModel();
    
        // Prepare view data
        $validator = JsValidator::make($this->addValidationRules, $this->validationMessages, [], "#addPollForm")->view('pages.admin.validations.validation-with-tabs');

        // Display view
        return $this->view('pages.admin.management.polls.add')
            ->with('poll', $poll)
            ->with('validator', $validator)
        ;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @redirect admin.polls
     */
    public function delete($id)
    {
        // Load poll
        $poll = PollModel::with('pollOptions')->find($id);
        // Remove if not empty
        if(!empty($poll)){
            $userHasPollOptions = UserHasPollOptionModel::whereHas('pollOption', function ($query) use ($id) {
                $query->whereHas('poll', function ($query) use ($id) {
                    $query->where('id', $id);
                });
            })->get();
            
            if (count($userHasPollOptions) > 0) {
                $errors = array('message' => 'No se pudo eliminar la entrada #' .$id. ' porque ya hay usuarios que la han respondido');
                return redirect()->route('management/polls')->withErrors($errors);
            }
            else {
                try {
                    // Remove questions
                    foreach ($poll->pollOptions as $pollOption) {
                        PollOptionModel::destroy($pollOption->id);
                    }
                    // Remove from database
                    PollModel::destroy($id);
                    
                    // Remove file
                    if($poll->image) {
                        $file = public_path($poll->image);
                        if(file_exists($file)) {
                            unlink($file);
                        }
                    }
                } catch(\Exception $e){
                    $errors = array('message' => 'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde');
                    return redirect()->route('management/polls')->withErrors($errors);
                }
            }
        }
        
        // Redirect to polls lsit
        return redirect()->route('management/polls');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return admin.polls.detail
     */
    public function detail($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Encuestas', route('management/polls'));
        $this->addBreadcrumb('Detalle', route('management/polls/detail',$id));
        
        // Set Title and subtitle
        $this->title = 'Encuesta';
        $this->subtitle = 'entrada #'.$id;
        
        // Find poll by id
        $poll = PollModel::with('pollOptions')->find($id);
        
        if ($poll) {
            // Display view
            return $this->view('pages.admin.management.polls.detail')
                ->with('poll', $poll)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
         
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return admin.polls.detail
     */
    public function result($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Encuestas', route('management/polls'));
        $this->addBreadcrumb('Resultados', route('management/polls/result',$id));
        
        // Set Title and subtitle
        $this->title = 'Encuesta';
        $this->subtitle = 'entrada #'.$id;
        
        // Find poll by id
        $poll = PollModel::with('pollOptions')->find($id);
        
        // Get poll result
        $parameters = array(
            'pollId' => $id,
            'userHasPollOption' => true,
        );
        $pollResults = PollOptionModel::findAll($parameters);
        $hasBeenResponded = false;
        foreach ($pollResults as $pollResult) {
            if (count($pollResult->userHasPollOptions)  > 0)
                $hasBeenResponded = true;
        }
        if ($poll) {
            // Display view
            return $this->view('pages.admin.management.polls.result')
                ->with('elements', json_encode($pollResults))
                ->with('hasBeenResponded', $hasBeenResponded)
                ->with('poll', $poll)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return admin.polls.edit
     */
    public function edit($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Encuestas', route('management/polls'));
        $this->addBreadcrumb('Editar', route('management/polls/edit',$id));
        
        // Set Title and subtitle
        $this->title = 'Encuesta';
        $this->subtitle = 'editar entrada #'.$id;
        
        // Load poll
        $poll = PollModel::with('pollOptions')->find($id);
        
        // Validate if user has respond the poll
        $userHasPollOptions = UserHasPollOptionModel::whereHas('pollOption', function ($query) use ($id) {
            $query->whereHas('poll', function ($query) use ($id) {
                $query->where('id', $id);
            });
        })->get();
        
        $allowEditQuestion = count($userHasPollOptions) == 0;
        
        if($poll){
            // Prepare view data
            $editValidator = JsValidator::make($this->editValidationRules, $this->validationMessages, [], "#editPollForm")->view('pages.admin.validations.validation-with-tabs');
            
            $totalPollOptions = count($poll->pollOptions);
            
            // Display view
            return $this->view('pages.admin.management.polls.edit')
                ->with('editValidator', $editValidator)
                ->with('poll', $poll)
                ->with('totalPollOptions', $totalPollOptions)
                ->with('allowEditQuestion', $allowEditQuestion)
                
            ;
        } else {
            return response()->view('errors.admin.404');
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return admin.polls.add
     */
    public function store(Request $request)
    {
        // Get values
        $values = $request->all();
        
        // Validate
        $this->validate($request, $this->addValidationRules, $this->validationMessages);
        
        // Create new poll
        $poll = new PollModel();
        $poll->title = $values['title'];
        $poll->startDate = $values['startDate'];
        $poll->endDate = $values['endDate'];
        if (isset($values['enabled'])) {
            $poll->enabled = true;
        } else {
            $poll->enabled = false;
        }
        
        // Store in database
        $poll->save();
        
        // Store images
        if ($values['image'] != null) {
            $imageName = AdminUploadFileHelper::uploadFile($values['image'], self::FOLDER_NAME, $poll->id);
            	
            // Update file name
            $poll->image = AdminUploadFileHelper::UPLOADS_PATH . self::FOLDER_NAME . $imageName;
        }
        
        // Update poll
        $poll->save();
        
        // Store options
        if ($values['options'] != null) {
            foreach ($values['options'] as $option) {
                if ($option['title'] && $option['color']) {
                    $pollOption = new PollOptionModel();
                    $pollOption->title = $option['title'];
                    $pollOption->color = $option['color'];
                    $pollOption->poll_id = $poll->id;
                    $pollOption->save();
                }
            }
        }
        
        return redirect()->route('management/polls');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return admin.polls.edit
     */
    public function update(Request $request, $id)
    {
        // Get values
        $values = $request->all();
        
        // Validate
        $this->validate($request, $this->editValidationRules, $this->validationMessages);
        
        // Load poll
        $poll = PollModel::with('pollOptions')->find($id);
        $poll->title = $values['title'];
        $poll->startDate = $values['startDate'];
        $poll->endDate = $values['endDate'];
        if (isset($values['enabled'])) {
            $poll->enabled = true;
        } else {
            $poll->enabled = false;
        }
        
        if (isset($values['image']) && $values['image'] != null) {
            // Remove current image from server
            $file = public_path($poll->image);
            if(file_exists($file)){
                unlink($file);
            }
            // Store new image
            $imageName = AdminUploadFileHelper::uploadFile($values['image'], self::FOLDER_NAME, $poll->id);
            $poll->image = AdminUploadFileHelper::UPLOADS_PATH . self::FOLDER_NAME . $imageName;
        }
    
        // Update in database
        $poll->save();
        
        // Validate if user has respond the poll
        $userHasPollOptions = UserHasPollOptionModel::whereHas('pollOption', function ($query) use ($id) {
            $query->whereHas('poll', function ($query) use ($id) {
                $query->where('id', $id);
            });
        })->get();
        
        if (count($userHasPollOptions) == 0) {
            // Destroy previos options
            foreach ($poll->pollOptions as $pollOption) {
                PollOptionModel::destroy($pollOption->id);
            }
            
            // Store options
            if ($values['options'] != null) {
                foreach ($values['options'] as $option) {
                    if ($option['title'] && $option['color']) {
                        $pollOption = new PollOptionModel();
                        $pollOption->title = $option['title'];
                        $pollOption->color = $option['color'];
                        $pollOption->poll_id = $poll->id;
                        $pollOption->save();
                    }
                }
            }
        }
        
    
        return redirect()->route('management/polls');
    }

}