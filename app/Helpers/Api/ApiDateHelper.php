<?php

namespace App\Helpers\Api;

use Jenssegers\Date\Date;
use Illuminate\Support\Facades\App;
class ApiDateHelper
{	
    public static function formatDate($date, $format = null)
    {
        if(!$format) {
            $format = 'l j \d\e F \d\e Y';
        }

        // Initialize date
        $formatDate = new Date($date);
        
        // Return formatted date
        return $formatDate->format($format);
    }
 
}

