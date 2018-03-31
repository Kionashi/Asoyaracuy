<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\NewsEntry;
use App\Helpers\Api\ApiDateHelper;

class NewsEntryController extends Controller {
    
    public function detail() {
        // Get parameters
        $newsEntryId = Input::get('newsEntryId');
        
        // Find news entry
        $success = array();
        $newsEntry = NewsEntry::with('newsEntrySources')
                ->with('newsDigest.calendarDate')
                ->find($newsEntryId)
        ;
        
        // Check if news entry is present
        if($newsEntry) {
            // Add path to image and date format
            $newsEntry->newsDigest->calendarDate->date = ucfirst(ApiDateHelper::formatDate($newsEntry->newsDigest->calendarDate->date));
            
            // Prepare response
            $success['newsEntry'] = $newsEntry;
        }
        
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    
}