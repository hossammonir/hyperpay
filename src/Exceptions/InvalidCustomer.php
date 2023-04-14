<?php

namespace HossamMonir\HyperPay\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InvalidCustomer extends Exception
{
    public function render(): Response
    {
        return response([
            'error' => $this->getMessage(),
            'help' => 'Customer array should contain keys : [ firstName | lastName | email  | mobile ].'], 400);
    }
}
