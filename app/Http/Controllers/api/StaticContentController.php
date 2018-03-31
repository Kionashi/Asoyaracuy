<?php

namespace App\Http\Controllers\api;

use App\Models\StaticContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class StaticContentController extends Controller
{
    public function detail(Request $request) {
        // Get parameters
        $parameters = array(
            'section'   => Input::get('section')
        );
        
        // Find blog sections
        $staticContent = StaticContent::where('section', $parameters['section'])
            ->where('enabled', true)
            ->first()
        ;
        
        // Return blog sections
        return response()->json(['success' => $staticContent], $this->successStatus);
    }
}
