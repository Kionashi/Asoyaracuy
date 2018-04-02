<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

abstract class PaymentStatus extends Enums
{
    const APPROVED = 'APPROVED';
    const PENDING = 'PENDING';
    const REJECTED = 'REJECTED';

    public static function values() {
        return array(
            'APPROVED'  => PaymentStatus::APPROVED, 
            'PENDING'   => PaymentStatus::PENDING,
            'REJECTED'  => PaymentStatus::REJECTED
        );
    }
    
    public static function getFriendlyName($enum) {
        switch ($enum) {
            case PaymentStatus::APPROVED:
                return 'Aprobado';
            case PaymentStatus::PENDING:
                return 'Pendiente';
            case PaymentStatus::REJECTED:
                return 'Rechazado';
        }
    }
}