<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BlogSection as BlogSectionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class BlogSectionsController extends Controller {
    
    public function index(Request $request) {
        // Get parameters
        $parameters = array(
            'active'    => Input::get('active')
        );
        
        // Find blog sections
        $blogSections = BlogSectionModel::apiFindAll($this->configItems['rdn.app.blog-section-paginator-size'], $parameters);
        
        // Return blog sections
        return response()->json(['success' => $blogSections], $this->successStatus);
    }
    
}