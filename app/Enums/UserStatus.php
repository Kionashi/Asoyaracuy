<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

abstract class UserStatus extends Enums
{
    const ACTIVE = 'ACTIVE';
    const CREATED = 'CREATED';
    const DISABLED = 'DISABLED';

    public static function values() {
        return array(
            'ACTIVE'    => UserStatus::ACTIVE, 
            'CREATED'   => UserStatus::CREATED,
            'DISABLED'  => UserStatus::DISABLED
        );
    }
    
    public static function getColorClass($enum) {
        switch ($enum) {
            case UserStatus::ACTIVE:
                return '#00a65a';
            case UserStatus::CREATED:
                return '#3c8dbc';
            case UserStatus::DISABLED:
                return '#b40404';
        }
    }
    
    public static function getFriendlyName($enum) {
        switch ($enum) {
            case UserStatus::ACTIVE:
                return 'Activo';
            case UserStatus::CREATED:
                return 'Creado';
            case UserStatus::DISABLED:
                return 'Deshabilitado';
        }
    }
}