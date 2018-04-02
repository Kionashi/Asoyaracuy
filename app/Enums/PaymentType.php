<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

abstract class PaymentType extends Enums
{
    const CASH = 'CASH';
    const DEPOSIT = 'DEPOSIT';
    const TRANSFERENCE = 'TRANSFERENCE';

    public static function values() {
        return array(
            'CASH'    => PaymentType::CASH, 
            'DEPOSIT'   => PaymentType::DEPOSIT,
            'TRANSFERENCE'  => PaymentType::TRANSFERENCE
        );
    }
    
    public static function getFriendlyName($enum) {
        switch ($enum) {
            case PaymentType::CASH:
                return 'Efectivo';
            case PaymentType::DEPOSIT:
                return 'Deposito';
            case PaymentType::TRANSFERENCE:
                return 'Transferencia';
        }
    }
}