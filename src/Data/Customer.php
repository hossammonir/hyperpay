<?php

namespace HossamMonir\HyperPay\Data;

class Customer
{
    public function __construct(
        public readonly string $givenName,
        public readonly string $surname,
        public readonly string $mobile,
        public readonly ?string $email = null,
        public readonly ?string $merchantCustomerId = null,
    ) {
    }
}
