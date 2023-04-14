<?php

namespace HossamMonir\HyperPay\Enums;

enum HyperPayPaymentMethod: string
{
    case MADA = 'MADA';
    case VISA = 'VISA';
    case MASTERCARD = 'MASTERCARD';
    case APPLEPAY = 'APPLEPAY';
}
