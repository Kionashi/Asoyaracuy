<?php

namespace App\Http\Controllers\Admin\Management;

use App\Helpers\Admin\AdminAuthHelper;
use App\Models\AdminUser as AdminUserModel;
use App\Models\AdminUserHasAdminUserRole as AdminUserHasAdminUserRoleModel;
use App\Models\AdminUserRole as AdminUserRoleModel;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use JsValidator;
use App\Enums\AdminUserType;
use App\Http\Controllers\Admin\RDNAdminController;

class AdminUsers extends RDNAdminController
{
       /**
     * Define your validation messages in a property in
     * the controller to reuse the messages.
     */
    
    protected $validationMessages = [
        'email'         => 'Debe introducir un correo electrónico válido',
        'numeric'       => 'Este campo debe contener solo dígitos',
        'regex'         => 'La contraseña de tener al menos 8 caracteres, una mayúscula y una minúscula y un caracter especial',
        'required'      => 'Este campo es requerido',
        'required_with' => 'Este campo es requerido',
        'same'          => 'Las contraseñas deben coincidir',
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
            $this->addValidationRules['email'] = 'required|email|unique:admin_user,email';
            $this->addValidationRules['firstName'] = 'required';
            $this->addValidationRules['lastName'] = 'required';
            $this->addValidationRules['password'] = 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
            $this->addValidationRules['passwordConfirmation'] = 'required_with:password|same:password';
            $this->addValidationRules['phone'] = 'required|numeric';
            $this->addValidationRules['adminUserRoleIds[]'] = 'required';
                
            $this->editValidationRules['email'] = 'required|email|unique:admin_user,email';
            $this->editValidationRules['firstName'] = 'required';
            $this->editValidationRules['lastName'] = 'required';
            $this->editValidationRules['phone'] = 'required|numeric';
            $this->editValidationRules['adminUserRoleIds[]'] = 'required';

            $this->changePasswordValidationRules['password'] = 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
            $this->changePasswordValidationRules['passwordConfirmation'] = 'required_with:password|same:password';
    }            
    
    public function index()
    {
        // Load page configuration values
        $pageDefault = $this->configItems['rdn.admin.paginator-default.value'];
        $pageSizes = explode(",", $this->configItems['rdn.admin.paginator-sizes']);
        
        // Add breadcrumbs
        $this->addBreadcrumb('Administradores', route('management/admin-users'));
        
        // Set Title and subtitle
        $this->title = 'Administradores';
        
        // Get session user
        $sessionUser = $permissions = session()->get('admin.auth.admin-user');
        
        // Check if session user is admin type
        if ($sessionUser['type'] & AdminUserType::ADMIN) {
            // Find all admin users
            $adminUsers = AdminUserModel::all();
        }
        
       // Find types
       $types = array();
       foreach(AdminUserType::values() as $adminUserTypeValue) {
           $types[$adminUserTypeValue] = AdminUserType::getFriendlyName($adminUserTypeValue);
       }
       
       // Prepare typeFilterOptions
       $typeFilterOptions = array(
           'Special options' => array(
               'all' => 'All types'
           ),
           'Type' => $types
       );
           
        // Display view
        return $this->view('pages.admin.management.admin-users.index')
            ->with('adminUsers', $adminUsers)
            ->with('pageDefault', $pageDefault)
            ->with('pageSizes', $pageSizes)
            ->with('typeFilterOptions', $typeFilterOptions)
        ;
    }

    /**
     * Show the form for adding a new resource.
     *
     * @return admin.admin-users.add
     */
    public function add()
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Administrador', route('management/admin-users'));
        $this->addBreadcrumb('Agregar', route('management/admin-users/add'));
            
        // Set Title and subtitle
        $this->title = 'Administradores';
        $this->subtitle = 'agregar nueva entrada';
            
        // Create new admin user
        $adminUser = new adminUserModel();
        $types = array();
        
        if(AdminAuthHelper::hasPermission('management/admin-users/add', AdminUserType::ADMIN))
        {
            $types = array();
            
            foreach(AdminUserType::values() as $adminUserTypeName => $adminUserTypeValue){
                $types[$adminUserTypeValue] = $adminUserTypeName;
            }
            
            $adminUserRoles = AdminUserRoleModel::orderBy('name')
                ->pluck('name', 'id');
            ;
            
            // Adds validation rule of the type if is admin 
            $this->addValidationRules['types[]'] = 'required';
        }
        
        // Prepare view data
        $validator = JsValidator::make($this->addValidationRules, $this->validationMessages, [], "#addAdminUserForm")->view('pages.admin.validations.validation-with-tabs');
        
        // Display view
        return $this->view('pages.admin.management.admin-users.add')
            ->with('adminUser', $adminUser)
            ->with('adminUserRoles', $adminUserRoles)
            ->with('types', $types)
            ->with('validator', $validator)
        ;
    }
    
    public function changePassword($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Administradores', route('management/admin-users'));
        $this->addBreadcrumb('Cambiar contraseña', route('management/admin-users/edit',$id));
        
        // Set Title and subtitle
        $this->title = 'Administrador';
        $this->subtitle = 'cambiar contraseña entrada #'.$id;
        
        // Prepare view data
        $validator = JsValidator::make($this->changePasswordValidationRules, $this->validationMessages, [], "#changePasswordForm");
        
        // Load admin user
        $adminUser = $this->hasAccess('management/admin-users/change-password', $id);
        
        if($adminUser){
            // Display view
            return $this->view('pages.admin.management.admin-users.change-password')
                ->with('adminUser', $adminUser)
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
     * @redirect admin.admin-users
     */
    public function delete($id)
    {
        // Load admin user
        $adminUser = $this->hasAccess('management/admin-users/delete', $id);
        
        // Remove if not empty
        if($adminUser){
            try {
                // Try to delete admin user
                AdminUserModel::destroy($id);
                // Return to index page
                return redirect()->route('management/admin-users');
                 
            } catch(\Exception $e){
                // Catch exception and return error
                $errors = array('message' => 'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde');
                return redirect()->route('management/admin-users')->withErrors($errors);
            }
            
        } else {
            // Redirect to page not found error 404
            return response()->view('errors.admin.404');
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return admin.admin-users.detail
     */
    public function detail($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Administradores', route('management/admin-users'));
        $this->addBreadcrumb('Detalle', route('management/admin-users/detail',$id));
         
        // Set Title and subtitle
        $this->title = 'Administrador';
        $this->subtitle = 'entrada #'.$id;
        
        // Find Admin user by id
        
        $adminUser = $this->hasAccess('management/admin-users/detail', $id);
        
        if($adminUser){
            // Display view
            return $this->view('pages.admin.management.admin-users.detail')
                ->with('adminUser', $adminUser)
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
     * @return admin.admin-users.edit
     */
    public function edit($id)
    {
        // Add breadcrumbs
        $this->addBreadcrumb('Administradores', route('management/admin-users'));
        $this->addBreadcrumb('Editar', route('management/admin-users/edit',$id));
        
        // Set Title and subtitle
        $this->title = 'Administrador';
        $this->subtitle = 'editar entrada #'.$id;
        
        // Load admin user
        $adminUser = $adminUser = $this->hasAccess('management/admin-users/edit', $id);
        
        if($adminUser){
            
            // Get Admin User Roles types 
            $adminUserRolesTypes = $adminUser->adminUserRoles->pluck('admin_user_type','id')->toArray();
            
            // Find all admin user roles
            $adminUserRoles = AdminUserRoleModel::orderBy('name')
                ->where('admin_user_type', '&', $adminUser->type)
                ->get()
                ->pluck('name', 'id')
                ->toArray()
            ;
            
            // Select admin user roles    
            $selectedAdminUserRoles = array();
            foreach ($adminUser->adminUserRoles as $adminUserRole) {
                $selectedAdminUserRoles[$adminUserRole->id] = $adminUserRole->id;            
            }
            
            // Prepare view data
            $editValidator = JsValidator::make($this->editValidationRules, $this->validationMessages, [], "#editAdminUserForm")->view('pages.admin.validations.validation-with-tabs');
        
            // Display view
            return $this->view('pages.admin.management.admin-users.edit')
                ->with('adminUser', $adminUser)
                ->with('adminUserRoles', $adminUserRoles)
                ->with('editValidator', $editValidator)
                ->with('selectedAdminUserRoles', $selectedAdminUserRoles)
            ;
        } else {
            return response()->view('errors.admin.404');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return admin.admin-users.add
     */
    public function store(Request $request)
    {    
        // Update rules
        $this->addValidationRules['adminUserRoleIds[]'] = '';
        $this->addValidationRules['adminUserRoleIds'] = 'required';
        
        // Get values
        $values = $request->all();
        
        // Validate
        $this->validate($request, $this->addValidationRules, $this->validationMessages);
            
        // Create new admin user item
        $adminUser = new AdminUserModel();
        $adminUser->email = $values['email'];
        $adminUser->firstName = $values['firstName'];
        $adminUser->lastName = $values['lastName'];
        $adminUser->password = sha1($values['password']);
        $adminUser->phone = $values['phone'];
        $adminUser->type = AdminUserType::ADMIN;
        $adminUserRoleIds = $values['adminUserRoleIds'];
        
        // Set enabled
        if (isset($values['enabled'])) {
            $adminUser->enabled = true;
        } else {
            $adminUser->enabled = false;
        }
        
        // Store in database
        $adminUser->save();

        //Load all roles    
        $adminUserRoles = AdminUserRoleModel::get()->pluck('admin_user_type', 'id')->toArray();
        
        foreach ($adminUserRoleIds as $adminUserRoleId) {

            if($adminUser->type & $adminUserRoles[$adminUserRoleId]){
                
                $adminUserHasAdminUserRole = new AdminUserHasAdminUserRoleModel();
                $adminUserHasAdminUserRole->adminUserRoleId = $adminUserRoleId;
                $adminUserHasAdminUserRole->adminUserId = $adminUser->id;
                $adminUserHasAdminUserRole->save();
            }else{
                return redirect()->route('management/admin-users');
            }
        }
        
        // Prepare data for send notification email
        $data = [
            'adminUser'=>$adminUser,
            'logoUrl' => asset('admin/images/logo.png'),
            'notificationMessage' => 'Su cuenta ha creada por el administrador del sistema. Su contraseña es: '.$values['password'],
            'url' => route('sign-in')
        ];
        
        // Send notification email
        $fromAddress = $this->configItems['rdn.general.email.from'];
        $fromName = $this->configItems['rdn.general.email.name'];
        // TODO: FIX EMAILS
//         Mail::queue('pages.admin.emails.notification-admin-user-creation', $data, function ($message) use ($fromAddress, $fromName, $adminUser) {
//             $message
//                 ->from($fromAddress, $fromName)
//                 ->to($adminUser->email, $adminUser->fullName())
//                 ->subject('Your account has been created')
//             ;
//         });
        
        // Redirect to admin users list
        return redirect()->route('management/admin-users');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return admin.admin-users.edit
     */
    public function update(Request $request, $id)
    {
        
        // Update rules
        $this->editValidationRules['adminUserRoleIds[]'] = '';
        $this->editValidationRules['adminUserRoleIds'] = 'required';
        
        
        // Get values
        $values = $request->all();
        
        // Validate
        $this->editValidationRules['email'] = "required|email|unique:admin_user,email,".$request->id;
        $this->validate($request, $this->editValidationRules, $this->validationMessages);
        
        // Load admin user
        $adminUser = $adminUser = $this->hasAccess('management/admin-users/edit', $id);
        if($adminUser){
            
            $adminUser->email = $values['email'];
            $adminUser->firstName = $values['firstName'];
            $adminUser->lastName = $values['lastName'];
            $adminUser->phone = $values['phone'];
            $adminUser->phone = $values['phone'];
            
            $adminUserRoleIds = isset($values['adminUserRoleIds'])?$values['adminUserRoleIds']:null;
            if($adminUserRoleIds){
                
                $oldAdminUserRoleIds = $adminUser->adminUserRoles->pluck('id')->toArray();
                $oldAdminUserRoles = $adminUser->adminUserRoles;
                
                // Set enabled
                if (isset($values['enabled'])) {
                    $adminUser->enabled = true;
                } else {
                    $adminUser->enabled = false;
                }
                
                // Add new admin user role
                foreach ($adminUserRoleIds as $adminUserRoleId) {
                    if(!in_array($adminUserRoleId, $oldAdminUserRoleIds)){
                        $adminUser->adminUserRoles()->attach($adminUserRoleId, array('admin_user_role_id' => $adminUserRoleId));
                        $adminUser->save();
                    }
                }
                
                // Remove admin user role
                foreach ($oldAdminUserRoles as $oldAdminUserRole) {
                    if(AdminAuthHelper::hasPermission('management/admin-users/edit', $oldAdminUserRole->type)){
                        if(!in_array($oldAdminUserRole->id, $adminUserRoleIds)){
                            $adminUser->adminUserRoles()->detach($oldAdminUserRole->id);
                            $adminUser->save();
                        }
                    }
                }
            }
            
            $message = 'Su información ha sido actualizada por el administrador del sistema.';
            
            // Update in database
            $adminUser->save();
            
            // Prepare data for send notification email
            $data = [
                'adminUser' => $adminUser,
                'logoUrl' => asset('admin/images/logo.png'),
                'notificationMessage' => $message,
                'url' => route('sign-in')
            ];
             
            // Send notification email
            $fromAddress = $this->configItems['rdn.general.email.from'];
            $fromName = $this->configItems['rdn.general.email.name'];
            // TODO: Send emails
//             Mail::queue('pages.admin.emails.notification-admin-user-edit', $data, function ($message) use ($fromAddress, $fromName, $adminUser) {
//                 $message
//                     ->from($fromAddress, $fromName)
//                     ->to($adminUser->email, $adminUser->fullName())
//                     ->subject('Your account has been updated')
//                 ;
//             });
            
             // Redirect to admin users list
            return redirect()->route('management/admin-users');
        }else{
            return response()->view('errors.admin.404');
        }
    }

        
    public function updatePassword (Request $request, $id)
    {
        // Get values
        $values = $request->all();
    
        // Validate
        $this->validate($request, $this->changePasswordValidationRules, $this->validationMessages);
        
        // Load admin user
        $adminUser = $this->hasAccess('management/admin-users/change-password', $id);
        
        if($adminUser){
            
            // Update password
            $adminUser->password = sha1($values['password']);
            $message = "Su información ha sido actualizada por un administrador del sistema. Su nueva contraseña es: ".$values['password'];
            
            // Update in database
            $adminUser->save();
            
                // Prepare data for send notification email
            $data = [
                'adminUser' => $adminUser,
                'logoUrl' => asset('admin/images/logo.png'),
                'notificationMessage' => $message,
                'url' => route('sign-in')
            ];
            
            // Send notification email
            // Send mail to customer
            $fromAddress = $this->configItems['rdn.general.email.from'];
            $fromName = $this->configItems['rdn.general.email.name'];
            // TODO: FIX EMAILS
//             Mail::queue('pages.admin.emails.notification-admin-user-edit', $data, function ($message) use ($fromAddress, $fromName, $adminUser) {
//                 $message
//                     ->from($fromAddress, $fromName)
//                     ->to($adminUser->email, $adminUser->fullName())
//                     ->subject('Your account has been updated')
//                 ;
//             });
        
            // Redirect to admin users edit
            return redirect()->route('management/admin-users/edit',$id);
            
        }else{
            return response()->view('errors.admin.404');
        }
        
        }
        

    private function hasAccess($permission, $id)
    {
        // Load admin user 
        $adminUser = AdminUserModel::where('id', $id)
            ->with('adminUserRoles')
            ->first()
        ;
        
        if($adminUser){
            if(AdminAuthHelper::hasPermission($permission, AdminUserType::ADMIN)){
               return $adminUser;
            }
        }
        return $adminUser;
    }
    
}
