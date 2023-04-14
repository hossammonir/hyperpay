<?php

namespace HossamMonir\HyperPay\Traits;

use Illuminate\Support\Facades\Http;

trait Processor
{
    /**
     * hyperpay checkout api request
     */
    public function PrepareCheckout()
    {
        return Http::baseUrl($this->endpoint)
            ->withToken($this->accessToken)
            ->asForm()
            ->withOptions(['verify' => ! $this->isTestMode == true])
            ->post('v1/checkouts', $this->checkoutConfig())
            ->json();
    }

    /**
     * get payment status api request
     */
    public function PaymentStatus(string $checkoutId): array
    {
        return Http::baseUrl($this->endpoint)
            ->withToken($this->accessToken)
            ->withOptions(['verify' => ! $this->isTestMode == true])
            ->get("v1/checkouts/$checkoutId/payment", $this->paymentStatusConfig())
            ->json();
    }

    /**
     * get payment transactions report api request
     */
    public function TransactionReport(string $checkoutId): array
    {
        return Http::baseUrl($this->endpoint)
            ->withToken($this->accessToken)
            ->withOptions(['verify' => ! $this->isTestMode == true])
            ->get("v1/query/$checkoutId", $this->paymentReportConfig())
            ->json();
    }

    /**
     * get settlement report api request
     */
    public function SettlementReport(): array
    {
        return Http::baseUrl($this->endpoint)
            ->withToken($this->accessToken)
            ->withOptions(['verify' => ! $this->isTestMode == true])
            ->get('reports/v1/reconciliations/aggregations', $this->settlementReportConfig())
            ->json();
    }

    /**
     * refund payment api request
     */
    public function refund(string $checkoutId): array
    {
        return Http::baseUrl($this->endpoint)
            ->withToken($this->accessToken)
            ->asForm()
            ->withOptions(['verify' => ! $this->isTestMode == true])
            ->post("v1/payments/$checkoutId", $this->refundConfig())
            ->json();
    }

    /**
     * reverse payment api request
     */
    public function reverse(string $checkoutId): array
    {
        return Http::baseUrl($this->endpoint)
            ->withToken($this->accessToken)
            ->asForm()
            ->withOptions(['verify' => ! $this->isTestMode == true])
            ->post("v1/payments/$checkoutId", $this->reverseConfig())
            ->json();
    }
}
