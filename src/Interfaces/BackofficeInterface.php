<?php

namespace HossamMonir\HyperPay\Interfaces;

interface BackofficeInterface
{
    public function setMethod(string $paymentMethod): static;

    public function setAmount(string $amount): static;

    public function setCurrency(string $currency = null): static;

    public function setCheckoutId(string $checkoutId): static;
}
