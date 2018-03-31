<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\UserNotification;
use App\Models\Country;

class PassportController extends Controller
{
    public function activateAccount(Request $request) {
        // Find user
        $user =  User::find($request->userId);
        
        // Check if activation code is valid
        if($user->activation_code == $request->input('activationCode')) {
            // Update user
            $user->activation_date = Carbon::now();
            $user->activation_ip_address = $request->ip();
            $user->status = UserStatus::ACTIVE;
            $user->save();
            
            // Auth user
            Auth::user();
            
            // Prepare response
            $success['token'] = 'Bearer '.$user->createToken('RDN-App')->accessToken;
            $success['user']['username'] = $user->username;
            return response()->json(['success'=>$success], $this->successStatus);
        } else {
            return response()->json(['error' => __('api/auth.failed-activate')], $this->successStatus);
        }
    }
    
    public function register(Request $request) {
        $messages = [
            'email.unique' => 'El correo electrónico ingresado no se encuentra disponible',
            'required' => 'Este campo es requerido.',
            'username.unique' => 'El nombre de usuario ingresado no se encuentra disponible'
        ];
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:user,email',
            'username' => 'required|unique:user,username',
        ], $messages);
        
        // Check validations
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], $this->successStatus);
        }
        
        // Create user
        $userData['activation_code'] = sprintf("%06d", mt_rand(1, 999999));
        $userData['birth_date'] = $request->input('birthDate');
        $userData['city'] = $request->input('city');
        $userData['email'] = $request->input('email');
        $userData['enabled'] = true;
        $userData['first_name'] = $request->input('firstName');
        $userData['gender'] = $request->input('gender');
        $userData['last_name'] = $request->input('lastName');
        $userData['password'] = bcrypt($request->input('password'));
        $userData['phone'] = $request->input('phone');
        $userData['register_date'] = Carbon::now();
        $userData['register_ip_address'] = $request->ip();
        $userData['status'] = UserStatus::CREATED;
        $userData['username'] = $request->input('username');
        $userData['country_id'] = $request->input('country');
        $user = User::create($userData);
        
        // Create user notification
        $userNotificationData['app'] = true;
        $userNotificationData['user_id'] = $user->id;
        UserNotification::create($userNotificationData);
        
        // Create response
        $success['id'] =  $user->id;
        $success['name'] =  $user->username;
        $success['token'] = 'Bearer '.$user->createToken('RDN-App')->accessToken;
        return response()->json(['success'=>$success], $this->successStatus);
    }
    
    public function registerInformation() {
        // Get countries
        $countries = Country::where('enabled', true)
            ->orderBy('name', 'ASC')
            ->get()
        ;
        return response()->json(['success'=>$countries], $this->successStatus);
    }
    
    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            // Check if user status
            $user = Auth::user();
            $success['token'] = 'Bearer '.$user->createToken('RDN-App')->accessToken;
            $success['user']['username'] = $user->username;
            switch ($user->status) {
                case UserStatus::ACTIVE:
                    return response()->json(['success' => $success], $this->successStatus);
                case UserStatus::CREATED:
                    return response()->json(['user_status' => UserStatus::CREATED, 'user_id' => $user->id], $this->successStatus);
                case UserStatus::DISABLED:
                    return response()->json(['error' => __('api/auth.user-disabled')], $this->successStatus);
                    break;
            }
        }else{
            return response()->json(['error' => __('api/auth.failed-login')], $this->successStatus);
        }
    }
    
    public function logout() {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['success' => __('api/auth.success-logout')], $this->successStatus);
        }else{
            return response()->json(['error' => __('api/auth.failed-logout')], $this->successStatus);
        }
    }
}
