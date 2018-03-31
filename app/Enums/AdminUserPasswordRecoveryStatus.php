<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

abstract class AdminUserPasswordRecoveryStatus extends Enums
{
	
	const CREATED = 'CREATED';
	const EXPIRED = 'EXPIRED';
	const USED = 'USED';
	
	public static function values() {
		return array(
			'CREATED' 	=> AdminUserPasswordRecoveryStatus::CREATED,
			'EXPIRED' 	=> AdminUserPasswordRecoveryStatus::EXPIRED, 
			'USED'		=> AdminUserPasswordRecoveryStatus::USED	
		);
	}
	
	public static function getFriendlyName($enum) {
	
		return ucfirst(trans('enum/admin-user-password-recovery-status.'.str_replace('_', '-', strtolower($enum)), [], null, App::getLocale()));
	}
	
	public static function getColorClass($enum) {
		switch ($enum) {
			case AdminUserPasswordRecoveryStatus::CREATED:
				return '#3c8dbc';
			case AdminUserPasswordRecoveryStatus::EXPIRED:
				return '#b40404';
			case AdminUserPasswordRecoveryStatus::USED:
				return '#00a65a';
		}
	}
	
}