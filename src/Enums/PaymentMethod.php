<?php

namespace HossamMonir\HyperPay\Enums;

enum PaymentMethod: string
{
    case MADA = 'MADA';
    case VISA = 'VISA';
    case MASTERCARD = 'MASTERCARD';
    case APPLEPAY = 'APPLEPAY';
}
