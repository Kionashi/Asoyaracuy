<?php

namespace App\Helpers\Admin;

use Jenssegers\Date\Date;

class AdminDateHelper
{	
	public static function formatDate($date)
	{
		// Initialize date
		$formatDate = new Date($date);
	
		// Set format date
		$formatDate = $formatDate->format('m-d-Y h:i A');
	
		// Return date
		return $formatDate;
	}
	
	public static function formatDateByFormat($date, $format)
	{
		// Initialize date
		$formatDate = new Date($date);
	
		// Set format date
		$formatDate = $formatDate->format($format);
	
		// Return date
		return $formatDate;
	}
 
}

