<?php
namespace App\Http\Controllers\api;

use App\Helpers\Api\ApiDateHelper;
use App\Http\Controllers\Controller;
use App\Models\NewsAlert;
use App\Models\NewsDigest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class NewsController extends Controller {
    
    public function index(Request $request) {
        // Get parameters
        $date = Input::get('date');
        
        // Find news digests
        $newsDigests = NewsDigest::with('calendarDate')->where('enabled', true)->whereHas('calendarDate', function ($query) use ($date) {
            $query->where('date', '=', $date);
        })->get();
        
        // Add news digests image base URL to image
        foreach ($newsDigests as $key => $newsDigest) {
            $newsDigests[$key]['image'] = asset('/') . $newsDigests[$key]['image'];
            $newsDigests[$key]->calendarDate->date = ApiDateHelper::formatDate($date);
        }
        
        $newsAlerts = NewsAlert::with('calendarDate')->where('enabled', true)->whereHas('calendarDate', function ($query) use ($date) {
            $query->where('date', '=', $date);
        })->get();
        
        // Add news digests image base URL to image
        foreach ($newsAlerts as $key => $newsAlert) {
            $newsAlerts[$key]['image'] = asset('/') . $newsAlerts[$key]['image'];
            $newsAlerts[$key]->calendarDate->date = ApiDateHelper::formatDate($date);
        }
        
        $response = [
            'newsDigests' => $newsDigests,
            'newsAlerts' => $newsAlerts
        ];
        
        // Return entries
        return response()->json(['success' => $response], $this->successStatus);
    }
    
    public function getDailyNewsAlerts(Request $request) {
        // Get parameters
        $date = Input::get('date');
        
        // Find news alerts
        $newsAlerts = NewsAlert::with('newsAlertSources')->with('calendarDate')->where('enabled', true)->whereHas('calendarDate', function ($query) use ($date) {
            $query->where('date', '=', $date);
        })->get();
        
        // Add news alerts image base URL to image
        foreach ($newsAlerts as $key => $newsAlert) {
            $newsAlerts[$key]['image'] = asset('/') . $newsAlerts[$key]['image'];
            $newsAlerts[$key]->date = ucfirst(ApiDateHelper::formatDate($newsAlerts[$key]->date, 'l j \d\e F \d\e Y, h:m A'));
        }
        
        $response = [
            'currentDate'  => ucfirst(ApiDateHelper::formatDate($date)),
            'newsAlerts'   => $newsAlerts
        ];
        
        // Return entries
        return response()->json(['success' => $response], $this->successStatus);
    }
    
}