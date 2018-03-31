<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

abstract class ClientType extends Enums
{
    const ANDROID = 'ANDROID';
    const IOS = 'IOS';
    const WEB = 'WEB';

    public static function values() {
        return array(
            'ANDROID'   => ClientType::ANDROID, 
            'IOS'       => ClientType::IOS,
            'WEB'       => ClientType::WEB
        );
    }
    
    
    public static function getFriendlyName($enum) {
        switch ($enum) {
            case ClientType::ANDROID:
                return 'Android';
            case ClientType::IOS:
                return 'iOS';
            case ClientType::WEB:
                return 'Sitio web';
        }
    }
}