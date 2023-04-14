<?php

namespace HossamMonir\HyperPay\Interfaces;

use HossamMonir\HyperPay\Enums\HyperPayPaymentMethod;

interface CheckoutInterface
{
    public function setMethod(HyperPayPaymentMethod $paymentMethod): static;

    public function setTransactionId(string $transactionId): self;

    public function setCurrency(string $currency = null): static;

    public function setAmount(string $amount): static;

    public function setCustomer(array $customer): static;

    public function setRegistrations(array $registrations = null): static;

    public function tokenizationCheckout(): array;

    public function oneClickCheckout(): array;

    public function basicCheckout(): array;
}
