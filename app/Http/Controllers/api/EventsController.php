<?php
namespace App\Http\Controllers\api;

use App\Helpers\Api\ApiDateHelper;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Input;
use Jenssegers\Date\Date;

class EventsController extends Controller
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
        
        // Check exist a event with selected date
        $parameters = array(
            'date'     => $currentDate,
        );        
        $currentEvent = Event::apiFind($parameters);
        
        // Return error if current event is not present and is not paginating
        if(!$nextDate && !$prevDate && !$currentEvent) {
            return response()->json(['error' => ''], $this->successStatus);
        }

        // Initialize parameters
        $parameters = array(
            'endDate'     => $endDate,
            'initDate'    => $initDate,
            'orderBy'     => $orderBy
        );
        
        // Find events
        $events = Event::apiFindAll($parameters);

        // Check if array is not empty
        if(!$events->isEmpty()) {
            $auxEvents = collect(new Event);
            $currentEventDate = null;
            $currentEventIndex = null;
            foreach ($events as $i => $event) {
                $events[$i]->image = asset('/') . $event->image;
                if($currentEventDate==null || $currentEventDate != $event->date) {
                    $currentEventDate = $event->date;
                    $auxEvent = new Event();
                    $auxEvent->date = $event->date;
                    $auxEvent->formatDate = ucfirst(ApiDateHelper::formatDate($event->date));
                    $auxEvent->childEvents = collect();
                    $auxEvent->childEvents->push($event);
                    $auxEvents->push($auxEvent);
                    $currentEventIndex = count($auxEvents)-1;
                } else {
                    $auxEvents[$currentEventIndex]->childEvents->push($event);
                }
            }
            
            // Check if should remove first and last element
            if($requestCurrentDate!=null) {
                if($auxEvents->first()->date != $currentDate && $auxEvents[1]->date!= $currentDate) {
                    // Check if has more events after last date of current list
                    if($this->hasMore($auxEvents->first()->date, '>')) {
                        $success['prevDate'] = $auxEvents->first()->date;
                        $auxEvents->shift();
                    }
                }
                if($auxEvents->last()->date != $currentDate && $auxEvents[count($auxEvents)-2]->date!= $currentDate) {
                    // Check if has more events before last date of current list
                    if($this->hasMore($auxEvents->last()->date, '<')) {
                        $success['nextDate'] = $auxEvents->last()->date;
                        $auxEvents->pop();
                    }
                }
            } else {
                if($nextDate) {
                    if($auxEvents->last()->date != $currentDate) {
                        // Check if has more events before last date of current list
                        if($this->hasMore($auxEvents->last()->date, '<')) {
                            $success['nextDate'] = $auxEvents->last()->date;
                            $auxEvents->pop();
                        }
                    }
                }
                if($prevDate) {
                    if($auxEvents->last()->date != $currentDate) {
                        // Check if has more events after last date of current list
                        if($this->hasMore($auxEvents->last()->date, '>')) {
                            $success['prevDate'] = $auxEvents->last()->date;
                            $auxEvents->pop();
                        }
                    }
                }
            }
            // Set active item index used to position the active slide 
            $activeItemIndex = null;
            foreach ($auxEvents as $i => $auxEvent) {
                if($auxEvent->date == $currentDate) {
                    $activeItemIndex = $i;
                }
            }
            
            // Create success
            $success['activeItemIndex'] = $activeItemIndex!=null ? $activeItemIndex : 0;
            $success['events'] = $auxEvents;
            
            return response()->json(['success' => $success], $this->successStatus); 
        }
    }
    
    private function hasMore($date, $dateCondition) {
        $parameters = array(
            'date'          => $date,
            'dateCondition' => $dateCondition,
        );
        return Event::apiFind($parameters);
    }
}