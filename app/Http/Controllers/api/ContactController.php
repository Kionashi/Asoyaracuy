<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactReason;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;

class ContactController extends Controller {
    
    public function index() {
        $contactReasons = ContactReason::where('enabled', true)
            ->get()
        ;
        return response()->json(['success' => $contactReasons], $this->successStatus);
    }
    
    public function contact(Request $request) {
        // Find current user
        $user = Auth::user();
            
        // Create contact
        $contactData['date_contact'] = Carbon::now();
        $contactData['email'] = $user->email;
        $contactData['first_name'] = $user->first_name;
        $contactData['ip_address'] = $request->ip();
        $contactData['last_name'] = $user->last_name;
        $contactData['message'] = $request->input('message');
        $contactData['phone'] = $user->phone;
        $contactData['contact_reason_id'] = $request->input('contactReason');
        $contactData['user_id'] = $user->id;
        Contact::create($contactData);
        
        return response()->json(['success' => __('api/contact.success')], $this->successStatus);
    }
    
}