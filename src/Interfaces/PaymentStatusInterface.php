<?php

namespace HossamMonir\HyperPay\Interfaces;

interface PaymentStatusInterface
{
    public function setMethod(string $paymentMethod): static;

    public function setCheckoutId(string $checkoutId): static;

    public function getStatus(): array;
}
