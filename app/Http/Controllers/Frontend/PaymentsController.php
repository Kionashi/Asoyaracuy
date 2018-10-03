<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Payment;

class PaymentsController extends Controller
{
    public function create(Request $request){

    	//Getting the data from the request (form)
    	$amount = $request->amount;
    	$bank = $request->bank;
    	$confirmationCode = $request->confirmation_code;
    	$date = $request->date;
    	$file = $request->file;
    	$type = $request->type;
    	$note = 'Pago en revisión';
    	$status = 'PENDING';

    	//Getting the current user
    	$user = Auth::user();

    	//validate -_-U

    	$payment = new Payment();

    	$payment->amount = $amount;
    	$payment->bank = $bank;
    	$payment->confirmation_code = $confirmationCode;
    	$payment->date = $date;
    	$payment->note = $note;
    	$payment->type = $type;
    	$payment->status = $status;
    	$payment->user_id = $user->id;

    	$payment->save(); 

    	//If there is a file, get the extension, get the name, set the pdestination path and move the file there
    	if($file) {
    		
			$extension = $file->getClientOriginalExtension();
	    	$fileName = $payment->id.".".$extension;
	    	$destinationPath = 'payments';
	    	$path = $file->move($destinationPath,$fileName);
    		$payment->file = $path;
    		$payment->save();
    	}

    	return view('pages.frontend.home.index')
    			->with('user', $user)
    			->with('message','Pago registrado exitosamente')
    			;
    }
}
