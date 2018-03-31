<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

abstract class Enums
{
    public static function getFriendlyName($status) {
        $enumSnakeCase = snake_case(Enums::getShortName(get_called_class()));
        return ucfirst(trans('enum/'.str_replace('_', '-', $enumSnakeCase).'.'.str_replace('_', '-', strtolower($status)), [], null, App::getLocale()));
    }
    
    protected static function getShortName($class) {
        $reflection = new \ReflectionClass($class);
        return $reflection->getShortName();
    }
}