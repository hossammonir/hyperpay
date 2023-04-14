<?php

namespace HossamMonir\HyperPay\Interfaces;

interface PaymentReportInterface
{
    public function setMethod(string $paymentMethod): static;

    public function setCheckoutId(string $checkoutId): static;

    public function getTransactionReport(): array;
}
