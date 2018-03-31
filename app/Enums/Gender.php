<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

abstract class Gender extends Enums
{

    const FEMALE = 'FEMALE';
    const MALE = 'MALE';

    public static function values() {
        return array(
            'FEMALE'    => Gender::FEMALE, 
            'MALE'      => Gender::MALE
        );
    }
    
    public static function getFriendlyName($enum) {
        switch ($enum) {
            case Gender::FEMALE:
                return 'Femenino';
            case Gender::MALE:
                return 'Masculino';
        }
    }

}