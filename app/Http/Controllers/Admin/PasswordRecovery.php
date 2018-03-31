<?php

namespace App\Http\Controllers\Admin;


use App\Enums\AdminUserPasswordRecoveryStatus;
use App\Models\AdminUser;
use App\Models\AdminUserPasswordRecovery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use JsValidator;
use App\Mail\PasswordRecoveryMail;


class PasswordRecovery extends RDNAdminController
{
    
    /**
     * Define your validation messages in a property in
     * the controller to reuse the messages.
     */
    
    protected $validationMessages = [
        'email' => 'Debe introducir una dirección de correo válida',
        'regex'    => 'La contraseña de tener al menos 8 caracteres, una mayúscula y una minúscula y un caracter especial',
        'required' => 'Este campo es requerido',
        'required_with' => 'Este campo es requerido',
        'same' => 'Las contraseñas deben coincidir',
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @return admin.carousel-items.index
     */
    protected $passwordRecoveryValidationRules = array();
    protected $changePasswordValidationRules = array();
    
    public function __construct() {
        parent::__construct();
        
        $this->passwordRecoveryValidationRules['email'] = 'required|email';
        
        $this->changePasswordValidationRules['password'] = 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
        $this->changePasswordValidationRules['repeatPassword'] = 'required_with:password|same:password';
        
    }
    
    public function index()
    {
        // Create client side validator
        $validator = JsValidator::make($this->passwordRecoveryValidationRules, $this->validationMessages, [], '#password-recovery-form');
        
        // Show view
        return $this->view('pages.admin.password-recovery.index')
            ->with('validator', $validator)
        ;
        
    }
    
    public function changePassword($code)
    {
        // Load custom password recovery request
        $adminUserPasswordRecovery = AdminUserPasswordRecovery::where('code', $code)->first();
        
        // Verify code
        if ($adminUserPasswordRecovery) {
            switch ($adminUserPasswordRecovery->status) {
                case AdminUserPasswordRecoveryStatus::CREATED:
                    // Validation to change password
                    $validator = JsValidator::make($this->changePasswordValidationRules, $this->validationMessages, [], '#change-password-form');
                    
                    return $this->view('pages.admin.password-recovery.change-password')
                        ->with('adminUserPasswordRecovery', $adminUserPasswordRecovery)
                        ->with('validator', $validator)
                    ;
                    break;
                    
                case AdminUserPasswordRecoveryStatus::USED:
                    return $this->view('pages.admin.password-recovery.change-password')
                        ->with('errorMessage', 'The code for changing your password has expired.')
                    ;
                    break;
                    
                case AdminUserPasswordRecoveryStatus::EXPIRED:
                    return $this->view('pages.admin.password-recovery.change-password')
                        ->with('errorMessage', 'The code for changing your password has expired')
                    ;
                    break;
            }
        } else {
            return response()->view('errors.admin.public.404');
        }
    }
    
    public function messagePasswordChanged()
    {
        return $this->view('pages.admin.password-recovery.message-password-changed');
    }
    
    public function passwordRecovery(Request $request)
    {
        // Validate from server side
        $this->validate($request, $this->passwordRecoveryValidationRules);
        
        // Get form values
        $values = $request->all();
        $email = $values["email"];
        
        // Get adminUser that wants to do password recovery
        $adminUser = AdminUser::where('email', $email)->first();
        
        if ($adminUser != null) {
            
            $adminUserPasswordRecovery = AdminUserPasswordRecovery::where('admin_user_id', $adminUser->id)
                ->update(['status' => AdminUserPasswordRecoveryStatus::EXPIRED]);
                            
            // Save AdminUser Password Recovery
            $adminUserPasswordRecovery = new AdminUserPasswordRecovery();
            $adminUserPasswordRecovery->code = str_random(20);
            $adminUserPasswordRecovery->creationDate = date("Y-m-d H:i:s");
            $adminUserPasswordRecovery->creationIpAddress = $_SERVER['REMOTE_ADDR'];
            $adminUserPasswordRecovery->adminUserId = $adminUser->id;
            $adminUserPasswordRecovery->status = AdminUserPasswordRecoveryStatus::CREATED;
            
            $adminUserPasswordRecovery->save();
            // Prepare data for email
            $data = [
                'adminUser' => $adminUser,
                'logoUrl' => asset('admin/images/logo.png'),                    
                'url' => route('password-recovery/change-password', $adminUserPasswordRecovery->code)
            ];
            
            // Send notification email
            $fromAddress = $this->configItems['rdn.general.email.from'];
            $fromName = $this->configItems['rdn.general.email.name'];
            $template = 'pages.admin.emails.notification-recovery-password-change';
            
            // TODO: SEND EMAIL USING QUEUE
//             Mail::to($adminUser->email, $adminUser->fullName())
//                 ->queue(new PasswordRecoveryMail($template, $data, $fromAddress, $fromName, $adminUser));
//             Mail::queue('pages.admin.emails.notification-recovery-password-change', $data, function ($message) use ($fromAddress, $fromName, $adminUser) {
//                 $message
//                     ->from($fromAddress, $fromName)
//                     ->to($adminUser->email, $adminUser->fullName())
//                     ->subject('Password recovery')
//                 ;
//             });
            
            return redirect()->route('password-recovery')->with('successMessage', "Se ha enviado un correo a ".$email." con las instrucciones para reiniciar su password ");
        } else {
            
            return redirect()->route('password-recovery')->with('errorMessage', "No pudimos encontrar una cuenta con esa información");
        }

    }

    public function storeChangePassword(Request $request, $code)
    {
        $this->validate($request, $this->changePasswordValidationRules);
        
        // Get form values
        $values = $request->all();
                    
        $password = $values['password'];
        $repeatPassword = $values['repeatPassword'];
        $adminUserId = $values['adminUserId'];
        $adminUserPasswordRecoveryId = $values['adminUserPasswordRecoveryId'];
        
        $adminUser = AdminUser::where('id', $adminUserId)->first();
        $adminUserPasswordRecovery = AdminUserPasswordRecovery::where('id', $adminUserPasswordRecoveryId)->first();
            
        if ($adminUser != null) {
                
            // Update AdminUser Password Recovery
            $adminUserPasswordRecovery['usage_date'] = date("Y-m-d H:i:s");
            $adminUserPasswordRecovery['usage_ip_address'] = $_SERVER['REMOTE_ADDR'];
            $adminUserPasswordRecovery['status'] = AdminUserPasswordRecoveryStatus::USED;
            
            $adminUserPasswordRecovery->save();
            
            // Update AdminUser Password 
            $adminUser->password = sha1($password);
            
            $adminUser->save();
            
            // Prepare data for email
            $data = [
                'adminUser' => $adminUser,
                'logoUrl' => asset('admin/images/logo.png'),
                'url' => route('sign-in')
            ];
                 
            // Send mail to adminUser
            $fromAddress = $this->configItems['rdn.general.email.from'];
            $fromName = $this->configItems['rdn.general.email.name'];
            // TODO: SEND EMAIL USING QUEUE
//             Mail::queue('pages.admin.emails.notification-password-change', $data, function ($message) use ($fromAddress, $fromName, $adminUser) {
//                 $message
//                     ->from($fromAddress, $fromName)
//                     ->to($adminUser->email, $adminUser->fullName())
//                     ->subject('Password recovery')
//                 ;
//             });
                
            return redirect()->route('password-recovery/message-password-changed', $code)->with('successMessage', 'Su contraseña ha sido cambiada.');
        
        } else {
            return redirect()->route('password-recovery/message-password-changed', $code)->with('errorMessage', 'Ha ocurrido un error cambiando su contraseña. Por favor internar más tarde.');
        }
    }

}

