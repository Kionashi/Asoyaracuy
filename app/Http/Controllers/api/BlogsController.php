<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BlogEntry as BlogEntryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Helpers\Api\ApiDateHelper;
use App\Models\BlogView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BlogsController extends Controller {
    
    public function index(Request $request) {
        // Get parameters
        $parameters = array(
            'blogSectionId'    => Input::get('blogSectionId')
        );
        
        // Find entries
        $blogEntries = BlogEntryModel::apiFindAll($this->configItems['rdn.app.paginator-size'], $parameters);
        
        // Return entries
        return response()->json(['success' => $blogEntries], $this->successStatus);
    }
    
    public function getEntry(Request $request) {
        // Get parameters
        $blogEntryId = Input::get('blogEntryId');
        $platform = Input::get('platform');
        $parameters = array(
            'blogEntryId'    => $blogEntryId
        );
        
        // Find entries
        $blogEntry = BlogEntryModel::with('blogSection.blogCategory')->with('calendarDate')->find($blogEntryId);
        
        if ($blogEntry) {
            // Update image and date
            $blogEntry['image'] = asset('/') . $blogEntry['image'];
            $blogEntry->calendarDate->date = ucfirst(ApiDateHelper::formatDate($blogEntry->calendarDate->date));
            
            // Store view
            $user = Auth::user();
            $blogView = new BlogView();
            $blogView->ipAddress = $request->ip();
            $blogView->userAgent = $request->userAgent();
            $blogView->userId = $user->id;
            $blogView->blogEntryId = $blogEntryId;
            $blogView->date = Carbon::now();
            switch ($platform) {
                case 'Android':
                    $platform = 'ANDROID';
                    break;
                case 'iOS':
                    $platform = 'IOS';
                    break;
                default:
                    $platform = 'WEB';
                    break;
            }
            $blogView->clientType = $platform;
            $blogView->save();
        }
        
        // Return entries
        return response()->json(['success' => $blogEntry], $this->successStatus);
    }
    
}