<?php

namespace HossamMonir\HyperPay\Services;

use Exception;
use HossamMonir\HyperPay\Contracts\HyperPay;
use HossamMonir\HyperPay\Interfaces\SettlementReportInterface;
use HossamMonir\HyperPay\Traits\Processor;

class SettlementReport extends HyperPay implements SettlementReportInterface
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
     * set from date
     */
    public function setFromDate(string $fromDate): static
    {
        $this->config['date.from'] = $fromDate;

        return $this;
    }

    /**
     * set to date
     */
    public function setToDate(string $toDate): static
    {
        $this->config['date.to'] = $toDate;

        return $this;
    }

    /**
     * get payment settlement report.
     *
     * @throws Exception
     */
    public function getSettlement(): array
    {
        return $this->process();
    }

    /**
     * process payment settlement report.
     *
     * @throws Exception
     */
    private function process(): array
    {
        return $this->response(
            response: $this->SettlementReport(),
        );
    }

    /**
     * get settlement report response.
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
