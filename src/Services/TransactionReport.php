<?php

namespace HossamMonir\HyperPay\Services;

use Exception;
use HossamMonir\HyperPay\Contracts\HyperPay;
use HossamMonir\HyperPay\Interfaces\PaymentReportInterface;
use HossamMonir\HyperPay\Traits\Processor;

class TransactionReport extends HyperPay implements PaymentReportInterface
{
    use Processor;

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * set payment method.
     */
    public function setMethod(string $paymentMethod): static
    {
        $this->config['payment_method'] = $paymentMethod;

        return $this;
    }

    /**
     * set checkout id.
     */
    public function setCheckoutId(string $checkoutId): static
    {
        $this->config['checkout_id'] = $checkoutId;

        return $this;
    }

    /**
     * Submit Payment Status Request to HyperPay API.
     *
     * @throws Exception
     */
    public function getTransactionReport(): array
    {
        return $this->process();
    }

    /**
     * process settlement report.
     *
     * @throws Exception
     */
    private function process(): array
    {
        return $this->response(
            response: $this->TransactionReport(
                checkoutId: $this->config['checkout_id'],
            )
        );
    }

    /**
     *  payment status response.
     */
    private function response(array $response): array
    {
        return [
            'response' => $response,
            'props' => [
                'payment_method' => $this->config['payment_method'],
                'test_mode' => $this->isTestMode,
                'status' => [
                    'success' => $this->validateStatus($response['result']['code']),
                    'message' => $response['result']['description'],
                ],
            ],
        ];
    }
}
