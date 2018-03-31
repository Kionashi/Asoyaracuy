<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    
    public function recoverPassword(Request $request) {
        // Find user
        $user = User::where('username', $request->input('username'))
            ->first()
        ;
        
        // Check if user exist
        if($user) {
            // Update user
            $user->recover_code = sprintf("%06d", mt_rand(1, 999999));
            $user->save();
            
            // Prepare response
            $success['user_id'] = $user->id;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => __('api/user.error-recover-password')], $this->successStatus);
        }
    }
    
    public function updatePassword(Request $request) {
        // Find user
        $user =  User::find($request->userId);
        
        // Check if recover code is valid
        if($user->recover_code == $request->input('recoverCode')) {
            // Update user
            $user->password = bcrypt($request->input('password'));
            $user->recover_date = Carbon::now();
            $user->recover_ip_address = $request->ip();
            $user->save();
            return response()->json(['success' => __('api/user.success-update-password')], $this->successStatus);
        } else {
            return response()->json(['error' => __('api/user.error-update-password')], $this->successStatus);
        }
    }
    
    public function changePassword(Request $request) {
        // Auth user
        $user = Auth::user();
        
        // Check if recover code is valid
        if(password_verify($request->input('oldPassword'), $user->password)) {
            // Find user
            $user =  User::find($user->id);
            $user->password = bcrypt($request->input('password'));
            // Update user
            $user->save();
            return response()->json(['success' => __('api/user.success-update-password')], $this->successStatus);
        } else {
            return response()->json(['error' => __('api/user.error-wrong-current-password')], $this->successStatus);
        }
    }
    
    public function updateProfile(Request $request) {
       
        $messages = [
            'email.unique' => 'El correo electrónico ingresado no se encuentra disponible',
            'required' => 'Este campo es requerido.',
            'username.unique' => 'El nombre de usuario ingresado no se encuentra disponible'
        ];
        $validationRules = array();
        
        // Auth user
        $user = Auth::user();
        
        // Validate different email
        if ($user->email != $request->email) {
            $validationRules['email'] = 'required|email|unique:user,email';
        }
        
        // Validate different username
        if ($user->username != $request->username) {
            $validationRules['username'] = 'required|unique:user,username';
        }
        
        $validator = Validator::make($request->all(), $validationRules, $messages);
        
        // Check validations
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], $this->successStatus);
        }
        
        // Update user
        $user =  User::find($request->userId);
        $user->birth_date = $request->birthDate;
        $user->city = $request->city;
        $user->country_id = $request->country;
        $user->email = $request->email;
        $user->first_name = $request->firstName;
        $user->gender = $request->gender;
        $user->last_name = $request->lastName;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->save();
        
        return response()->json(['success' => __('api/user.success-update-profile')], $this->successStatus);
    }
    
    public function updateProfileInformation() {
        // Get countries
        $countries = Country::where('enabled', true)
            ->orderBy('name', 'ASC')
            ->get()
        ;
        
        // Auth user
        $user = Auth::user();
        
        return response()->json(['countries' => $countries, 'user' => $user], $this->successStatus);
    }
    
}