<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\IndicatorValue;
use Illuminate\Support\Facades\Input;
use App\Models\IndicatorCategory;
use Jenssegers\Date\Date;
use App\Models\Indicator;
use App\Helpers\Api\ApiDateHelper;
use App\Models\CalendarDate;

class IndicatorsController extends Controller
{
    public $successStatus = 200;
    
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
        
        // Check exist a indicator with selected date
        $parameters = array(
            'date'          => $currentDate,
        );
        $currentIndicator = IndicatorValue::apiFind($parameters);

        // Return error if current indicator is not present and is not paginating
        if(!$nextDate && !$prevDate && !$currentIndicator) {
            return response()->json(['error' => ''], $this->successStatus);
        }
        
        // Initialize parameters
        $parameters = array(
            'endDate'     => $endDate,
            'initDate'    => $initDate,
            'orderBy'     => $orderBy
        );
        
        // Find indicators
        $indicators = IndicatorValue::apiFindAll($parameters);
        
        // Check if array is not empty
        if(!$indicators->isEmpty()) {
            $indicatorsDates = $this->createIndicatorsDates($indicators);
        }

        // Check if should remove first and last element
        if($requestCurrentDate!=null) {
            if($indicatorsDates->first()->date != $currentDate && $indicatorsDates[1]->date!= $currentDate) {
                if($this->hasMore($indicatorsDates->first()->date, '>')) {
                    $success['prevDate'] = $indicatorsDates->first()->date;
                    $indicatorsDates->shift();
                }
            }
            if($indicatorsDates->last()->date != $currentDate && $indicatorsDates[count($indicatorsDates)-2]->date!= $currentDate) {
                // Check if has more indicators before last date of current list
                if($this->hasMore($indicatorsDates->last()->date, '<')) {
                    $success['nextDate'] = $indicatorsDates->last()->date;
                    $indicatorsDates->pop();
                }
            }
        } else {
            if($nextDate) {
                if($indicatorsDates->last()->date != $currentDate) {
                    // Check if has more indicators before last date of current list
                    if($this->hasMore($indicatorsDates->last()->date, '<')) {
                        $success['nextDate'] = $indicatorsDates->last()->date;
                        $indicatorsDates->pop();
                    }
                }
            }
            if($prevDate) {
                if($indicatorsDates->last()->date != $currentDate) {
                    // Check if has more indicators after last date of current list
                    if($this->hasMore($indicatorsDates->last()->date, '>')) {
                        $success['prevDate'] = $indicatorsDates->last()->date;
                        $indicatorsDates->pop();
                    }
                }
            }
        }
        
        // Set active item index used to position the active slide
        $activeItemIndex = null;
        foreach ($indicatorsDates as $i => $indicatorsDate) {
            if($indicatorsDate->date == $currentDate) {
                $activeItemIndex = $i;
            }
        }
        
        // Create success response
        $success['activeItemIndex'] = $activeItemIndex!=null ? $activeItemIndex : 0;
        $success['indicatorsDates'] = $indicatorsDates;
        
        return response()->json(['success' => $success], $this->successStatus);
    }
    
    private function createIndicator ($indicator) {
        $auxIndicator = new Indicator();
        $auxIndicator->name = $indicator->indicatorName;
        return $auxIndicator;
    }
    
    private function createIndicatorCategory ($indicator) {
        $indicatorCategory = new IndicatorCategory();
        $indicatorCategory->name = $indicator->indicatorCategoryName;
        $indicatorCategory->indicators = collect();
        return $indicatorCategory;
    }
    
    private function createIndicatorValue ($indicator) {
        $indicatorValue = new IndicatorValue();
        $indicatorValue->value = number_format((float)$indicator->value, 2, ',', '.');
        $indicatorValue->variation = number_format((float)$indicator->variation, 2, ',', '.');
        $indicatorValue->unit = $indicator->unit;
        if($indicator->variation > 0) {
            $indicatorValue['variation_style'] = '#00d900';
            $indicatorValue['variation_symbol'] = '+';
        }elseif ($indicator['variation'] < 0){
            $indicatorValue['variation_style'] = '#F53D3D';
        }
        return $indicatorValue;
    }
    
    private function createIndicatorsDates($indicators) {
        $indicatorDates = collect(new CalendarDate);
        $currentCategoryIndex = null;
        $currentCategoryId = null;
        $currentIndicatorDate = null;
        $currentIndicatorDateIndex = null;
        foreach ($indicators as $i => $indicator) {
            if($currentIndicatorDate==null || $currentIndicatorDate != $indicator->date) {
                $currentCategoryId = $indicator->indicatorCategoryId;
                $currentIndicatorDate = $indicator->date;
        
                // Create calendar date
                $indicatorDate = new CalendarDate();
                $indicatorDate->date = $indicator->date;
                $indicatorDate->formatDate = ucfirst(ApiDateHelper::formatDate($indicator->date));
        
                // Create indicator category
                $auxIndicatorCategory = $this->createIndicatorCategory($indicator);
        
                // Create indicator
                $auxIndicator = $this->createIndicator($indicator);
        
                // Create indicator value
                $auxIndicatorValue = $this->createIndicatorValue($indicator);
        
                // Add elements
                $auxIndicator->value = $auxIndicatorValue;
                $auxIndicatorCategory->indicators->push($auxIndicator);
                $indicatorDate->categories = collect();
                $indicatorDate->categories->push($auxIndicatorCategory);
                $indicatorDates->push($indicatorDate);
        
                // Update vars
                $currentCategoryIndex = count($indicatorDate->categories)-1;
                $currentIndicatorDateIndex = count($indicatorDates)-1;
            } else {
                if($currentCategoryId==null || $currentCategoryId != $indicator->indicatorCategoryId) {
                    $currentCategoryId = $indicator->indicatorCategoryId;
                    $currentIndicatorDate = $indicator->date;
        
                    // Create indicator category
                    $auxIndicatorCategory = $this->createIndicatorCategory($indicator);
        
                    // Create indicator
                    $auxIndicator = $this->createIndicator($indicator);
        
                    // Create indicator value
                    $auxIndicatorValue = $this->createIndicatorValue($indicator);
        
                    // Add elements
                    $auxIndicator->value = $auxIndicatorValue;
                    $auxIndicatorCategory->indicators->push($auxIndicator);
                    $indicatorDates[$currentIndicatorDateIndex]->categories->push($auxIndicatorCategory);
        
                    // Update vars
                    $currentCategoryIndex = count($indicatorDates[$currentIndicatorDateIndex]->categories)-1;
                    $currentIndicatorDateIndex = count($indicatorDates)-1;
                } else {
                    // Create indicator
                    $auxIndicator = $this->createIndicator($indicator);
                     
                    // Create indicator value
                    $auxIndicatorValue = $this->createIndicatorValue($indicator);
        
                    // Add elements
                    $auxIndicator->value = $auxIndicatorValue;
                    $indicatorDates[$currentIndicatorDateIndex]->categories[$currentCategoryIndex]->indicators->push($auxIndicator);
                    
                    // Update vars
                    $currentCategoryIndex = count($indicatorDates[$currentIndicatorDateIndex]->categories)-1;
                    $currentIndicatorDateIndex = count($indicatorDates)-1;
                }
            }
        }
        return $indicatorDates;
    }

    private function hasMore($date, $dateCondition) {
        $parameters = array(
            'date'          => $date,
            'dateCondition' => $dateCondition,
        );
        return IndicatorValue::apiFind($parameters);
    }
    
}