<?php
namespace App\Http\Controllers\api;

use App\Helpers\Api\ApiDateHelper;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\NewsDigest;
use Illuminate\Support\Facades\Input;
use Jenssegers\Date\Date;

class NewsDigestController extends Controller
{
    
    public function index() {
        // Initialize success array
        $success = array();
        
        // Get paginate params
        $nextDate = Input::get('nextDate');
        $prevDate = Input::get('prevDate');
        
        // Get offset days from config
        $offsetDays = 'P'.$this->configItems['rdn.app.search-offset-days'].'D';
        
        // Initialize dates
        $requestCurrentDate = Input::get('date');
        $initDate = null;
        $endDate = null;
        $orderBy = 'DESC';
        
        // Add offset days to dates
        if($requestCurrentDate!=null) {
            $currentDate = $requestCurrentDate;
            $initDate = new Date($requestCurrentDate);
            $initDate->sub(new \DateInterval($offsetDays));
            $endDate = new Date($requestCurrentDate);
            $endDate->add(new \DateInterval($offsetDays));
            
        }
        if($nextDate) {
            $currentDate = $nextDate;
            $endDate = new Date($nextDate);
            $initDate = new Date($nextDate);
            $initDate->sub(new \DateInterval($offsetDays));
        }
        if($prevDate) {
            $currentDate = $prevDate;
            $endDate = new Date($prevDate);
            $endDate->add(new \DateInterval($offsetDays));
            $initDate = new Date($prevDate);
            $orderBy = 'ASC';
        }
        
        // Check exist a news digest with selected date
        $parameters = array(
            'date'     => $currentDate,
        );        
        $currentNewsDigest = NewsDigest::apiFind($parameters);
        
        // Return error if current news digest is not present and is not paginating
        if(!$nextDate && !$prevDate && !$currentNewsDigest) {
            return response()->json(['error' => ''], $this->successStatus);
        }
        
        // Initialize parameters
        $parameters = array(
            'endDate'     => $endDate,
            'initDate'    => $initDate,
            'orderBy'     => $orderBy
        );
        
        // Find news digests
        $newsDigests = NewsDigest::apiFindAll($parameters);

        // Check if array is not empty
        if(!$newsDigests->isEmpty()) {
            // Check if should remove first and last element
            if($requestCurrentDate!=null) {
                if($newsDigests->first()->date != $currentDate && $newsDigests[1]->date!= $currentDate) {
                    // Check if has more news digests after last date of current list
                    if($this->hasMore($newsDigests->first()->date, '>')) {
                        $success['prevDate'] = $newsDigests->first()->date;
                        $newsDigests->shift();
                    }
                    
                }
                if($newsDigests->last()->date != $currentDate && $newsDigests[count($newsDigests)-2]->date!= $currentDate) {
                    // Check if has more news digests before last date of current list
                    if($this->hasMore($newsDigests->last()->date, '<')) {
                        $success['nextDate'] = $newsDigests->last()->date;
                        $newsDigests->pop();
                    }
                }    
            } else {
                if($nextDate) {
                    if($newsDigests->last()->date != $currentDate) {
                        // Check if has more news digests before last date of current list
                        if($this->hasMore($newsDigests->last()->date, '<')) {
                            $success['nextDate'] = $newsDigests->last()->date;
                            $newsDigests->pop();
                        }
                        
                    }
                }
                if($prevDate) {
                    if($newsDigests->last()->date != $currentDate) {
                        // Check if has more news digests after last date of current list
                        if($this->hasMore($newsDigests->last()->date, '>')) {
                            $success['prevDate'] = $newsDigests->last()->date;
                            $newsDigests->pop();
                        }
                    }
                }
            }
            
            // Load categories and entries
            $activeItemIndex = null;
            foreach ($newsDigests as $i => $newsDigest) {
                // Add format date and imagen base URL
                $newsDigests[$i]->formatDate = ucfirst(ApiDateHelper::formatDate($newsDigests[$i]->date));
                $newsDigests[$i]->image = asset('/') . $newsDigests[$i]->image;
        
                // Set active item index used to position the active slide
                if($newsDigest->date == $currentDate) {
                    $activeItemIndex = $i;
                }
        
                // Get categories and entries
                $parameters = array(
                    'loadNewsEntries'   => true,
                    'newsDigestId'      => $newsDigest->id
                );
                $newsCategories = NewsCategory::apiFindAll($parameters);
                $newsDigests[$i]->newsCategories = $newsCategories;
            }
            $success['activeItemIndex'] = $activeItemIndex!=null ? $activeItemIndex : 0;
            $success['newsDigests'] = $newsDigests;
            
            return response()->json(['success' => $success], $this->successStatus);
        }
    }
    
    private function hasMore($date, $dateCondition) {
        $parameters = array(
            'date'          => $date,
            'dateCondition' => $dateCondition,
        );
        return NewsDigest::apiFind($parameters);
    }
}