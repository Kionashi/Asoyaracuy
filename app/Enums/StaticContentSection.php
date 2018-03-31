<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

abstract class StaticContentSection extends Enums
{
    
    const ABOUT_US = 'ABOUT_US';
    const HELP = 'HELP';
    const QUESTIONS = 'QUESTIONS';
    
    public static function values() {
        return array(
            'ABOUT_US'  => StaticContentSection::getFriendlyName(StaticContentSection::ABOUT_US),
            'HELP'      => StaticContentSection::getFriendlyName(StaticContentSection::HELP),
            'QUESTIONS' => StaticContentSection::getFriendlyName(StaticContentSection::QUESTIONS),
        );
    }
    
    public static function getFriendlyName($enum) {
    
        return ucfirst(trans('enum/static-content-section.'.str_replace('_', '-', strtolower($enum)), [], null, App::getLocale()));
    }
    
}