<?php

namespace HossamMonir\HyperPay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class HyperPayFacade
 *
 * @mixin \HossamMonir\HyperPay\HyperPay
 *
 * @package HossamMonir\HyperPay\Facades
 */
class HyperPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'HyperPay';
    }
}
