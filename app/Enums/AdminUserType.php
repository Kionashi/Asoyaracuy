<?php

namespace App\Enums;

abstract class AdminUserType extends Enums
{
    
    const ADMIN = 1;
    
    public static function values() {
        return array(
            'ADMIN' => AdminUserType::ADMIN, 
        );
    }
    
public static function getColorClass($enum) {
        switch ($enum) {
            case AdminUserType::ADMIN:
                return '#3c8dbc';
        }
    }
}

