<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Admin\RDNAdminController;
use App\Helpers\Admin\AdminUploadFileHelper;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use JsValidator;
use Illuminate\Support\Facades\Hash;
use App\Enums\Gender;
use App\Models\Country;
use App\Enums\UserStatus;
use App\Models\User;
use App\Models\specialFee;

class UsersController extends RDNAdminController
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
    protected $orderOptions = array();
    protected $changePasswordValidationRules = array();
    
    public function __construct() {
        parent::__construct();
        $this->addValidationRules['balance'] = 'required|numeric';
        $this->addValidationRules['email'] = 'required|email|unique:user,email';
        // FIXME: Uncomment validation
//         $this->addValidationRules['password'] = 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
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
    
    /**
     * Display a listing of the resource.
     *
     * @return admin.users.index
     */
    
    public function index()
    {
        // Load page size values
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Load paginator default value
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        
        // Add breadcrumbs
        $this->addBreadcrumb('Usuarios', route('management/users'));
        
        // Set Title and subtitle
        $this->title = 'Usuarios';
        
        // Find all users
        $users = UserModel::all();
        
        // Display view
        return $this->view('pages.admin.management.users.index')
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes)
            ->with('users', $users)
        ;
    }

    /**
     * Show the form for adding a new resource.
     *
     * @return admin.users.add
     */
    public function add()
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Usuarios', route('management/users'));
        $this->addBreadcrumb('Agregar', route('management/users/add'));
    
        // Set Title and subtitle
        $this->title = 'Usuarios';
        $this->subtitle = 'agregar nueva entrada';
    
        // Create new user
        $user = new UserModel();
        
        // Prepare view data
        $validator = JsValidator::make($this->addValidationRules, $this->validationMessages, [], "#addUserForm")->view('pages.admin.validations.validation-with-tabs');

        // Display view
        return $this->view('pages.admin.management.users.add')
            ->with('user', $user)
            ->with('validator', $validator)
        ;
    }
    
    public function changePassword($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Usuarios', route('management/users'));
        $this->addBreadcrumb('Cambiar contraseña', route('management/users/edit',$id));
    
        // Set Title and subtitle
        $this->title = 'Usuarios';
        $this->subtitle = 'cambiar contraseña entrada #'.$id;
    
        // Prepare view data
        $validator = JsValidator::make($this->changePasswordValidationRules, $this->validationMessages, [], "#changePasswordForm");
    
        // Load user
        $user = User::find($id);
    
        if($user){
            // Display view
            return $this->view('pages.admin.management.users.change-password')
                ->with('user', $user)
                ->with('validator', $validator)
            ;
        } else {
            // Redirect to page not found error 404
            return response()->view('errors.admin.404');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @redirect admin.users
     */
    public function delete($id)
    {
        // Load user
        $user = UserModel::find($id);
        
        // Remove if not empty
        if(!empty($user)){
            try {
                // Check if user has a contact assigned
                if($user->contactCount) {
                    // Redirect with errors
                    $errors = array('message' => 'No se puede eliminar el usuario #' .$id. ' porque está asignado a un contacto');
                    return redirect()->route('management/users')->withErrors($errors);
                }
                
                // Remove from database
                UserModel::destroy($id);
                
                // Remove file
                if($user->image) {
                    $file = public_path($user->image);
                    if(file_exists($file)){
                        unlink($file);
                    }
                }
            } catch(\Exception $e){
                $errors = array('message' => 'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde');
                return redirect()->route('management/users')->withErrors($errors);
            }            
        }
        
        // Redirect to userr list
        return redirect()->route('management/users');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return admin.users.detail
     */
    public function detail($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Usuarios', route('management/users'));
        $this->addBreadcrumb('Detalle', route('management/users/detail',$id));
        
        // Set Title and subtitle
        $this->title = 'Usuarios';
        $this->subtitle = 'entrada #'.$id;
        
        // Find user by id
        $user = UserModel::find($id)
            ->with('specialFee');
        
        if ($user) {
            // Display view
            return $this->view('pages.admin.management.users.detail')
                ->with('user', $user)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
         
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return admin.users.edit
     */
    public function edit($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Usuarios', route('management/users'));
        $this->addBreadcrumb('Editar', route('management/users/edit',$id));
        
        // Set Title and subtitle
        $this->title = 'Usuarios';
        $this->subtitle = 'editar entrada #'.$id;
        
        // Load user
        $user = UserModel::where('id',$id)
                ->with('specialFee')
                ->first();

        // dump($user);die;
        
        if($user){
            // Prepare view data
            $editValidator = JsValidator::make($this->editValidationRules, $this->validationMessages, [], "#editUserForm")->view('pages.admin.validations.validation-with-tabs');
        
            // Display view
            return $this->view('pages.admin.management.users.edit')
                ->with('editValidator', $editValidator)
                ->with('user', $user)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return admin.users.add
     */
    public function store(Request $request)
    {
        // Get values
        $values = $request->all();
    
        // Validate
        $this->validate($request, $this->addValidationRules, $this->validationMessages);
         
        // Create new user
        $user = new UserModel();
        $user->balance = $values['balance'];
        $user->house = $values['house'];
        $user->email = $values['email'];
        $user->password = Hash::make($values['password']);
        $user->phone = $values['phone'];
        $user->register_date = date('Y-m-d H:i:s');
        $user->register_ip_address = $request->getClientIp();
        $user->status = UserStatus::ACTIVE;
        if (isset($values['enabled'])) {
            $user->enabled = true;
        } else {
            $user->enabled = false;
        }
        
        // Store in database
        $user->save();
        
        // Store audit
        $this->storeAudit('Crear usuario ['. $user->house.']', 'Usuario creado ' . $user->house, $request->getClientIp());
        
        return redirect()->route('management/users');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return admin.users.edit
     */
    public function update(Request $request, $id)
    {
        // Get values
        $values = $request->all();
    
        // Validate
        $this->editValidationRules['email'] = "required|email|unique:user,email,".$request->id;
        $this->editValidationRules['house'] = "required|unique:user,house,".$request->id;
        $this->validate($request, $this->editValidationRules, $this->validationMessages);
         
        // Load user
        $user = UserModel::find($id);
        $user->email = $values['email'];
        $user->balance = $values['balance'];
        $user->phone = $values['phone'];
        $user->house = $values['house'];
        if (isset($values['enabled'])) {
            $user->enabled = true;
        } else {
            $user->enabled = false;
        }
        
        // Update in database
        $user->save();
        
        // Store audit
        $this->storeAudit('Actualizar usuario ['. $user->house.']', 'Usuario actualizado ' . $user->house, $request->getClientIp());
        
        return redirect()->route('management/users');
    }
    
    public function updatePassword (Request $request, $id)
    {
        // Get values
        $values = $request->all();
    
        // Validate
        $this->validate($request, $this->changePasswordValidationRules, $this->validationMessages);
    
        // Load user
        $user = User::find($id);
    
        if($user){
            // Update password
            $user->password = sha1($values['password']);
            $message = "Su información ha sido actualizada por un administrador del sistema. Su nueva contraseña es: ".$values['password'];
            
            // Update in database
            $user->save();
            
            // Prepare data for send notification email
            $data = [
                'user' => $user,
                'logoUrl' => asset('admin/images/logo.png'),
                'notificationMessage' => $message,
                'url' => route('sign-in')
            ];
    
            // Send notification email
            // Send mail to user
            $fromAddress = $this->configItems['rdn.general.email.from'];
            $fromName = $this->configItems['rdn.general.email.name'];
            // TODO: FIX EMAILS
            //             Mail::queue('pages.admin.emails.notification-user-edit', $data, function ($message) use ($fromAddress, $fromName, $adminUser) {
            //                 $message
            //                     ->from($fromAddress, $fromName)
            //                     ->to($user->email, $user->firstName())
            //                     ->subject('Your account has been updated')
            //                 ;
            //             });
    
                // Redirect to admin users edit
                return redirect()->route('management/users/edit',$id);
    
        }else{
            return response()->view('errors.admin.404');
        }
    }

}
