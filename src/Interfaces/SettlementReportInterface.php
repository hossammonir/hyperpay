<?php

namespace HossamMonir\HyperPay\Interfaces;

interface SettlementReportInterface
{
    public function setMethod(string $paymentMethod): static;

    public function setFromDate(string $fromDate): static;

    public function setToDate(string $toDate): static;

    public function getSettlement(): array;
}
