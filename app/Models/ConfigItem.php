<?php

namespace App\Models;


class ConfigItem extends RDNModel
{
	public $timestamps = false;
	public $table = 'config_item';
	protected $fillable = ['description', 'key', 'value'];
	
	public static function listConfigItems()
	{
		// Load menu highlighted categories
		$configItems = array();
		ConfigItem::all()->map(function($item) use(&$configItems) {
			if(stripos($item->key,'settings')) {
				$configItems[ substr($item->key,0,stripos($item->key,'settings')+strlen("settings"))][substr($item->key,stripos($item->key,'settings')+strlen("settings")+1)] =  $item->value; 
			} else {
		    	$configItems[$item->key] = $item->value;
			}
		});
		
		// Return menu highlighted categories
		return $configItems;
	}
}
