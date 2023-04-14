<?php

namespace HossamMonir\HyperPay\Contracts;

use HossamMonir\HyperPay\Exceptions\InvalidPaymentMethod;
use Illuminate\Support\Arr;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

abstract class HyperPay
{
    /**
     * configurations array
     */
    protected array $config;

    /**
     * hyperpay endpoint ( Live || Test )
     */
    protected string $endpoint;

    /**
     * hyperpay access token
     */
    protected string $accessToken;

    /**
     * bind environment mode ( Live || Test )
     */
    protected bool $isTestMode;

    /**
     * initialize api processor constructor.
     * accept all hyperpay api parameters.
     *
     * @throws InvalidPaymentMethod
     */
    public function __construct($config)
    {
        $this->setConfig($config);
    }

    /**
     * switch between live and test mode.
     */
    protected function setEnvironment(): bool
    {
        return (bool) config('hyperpay.config.test_mode') === true ? $this->isTestMode = true : $this->isTestMode = false;
    }

    /**
     * set hyperpay configurations.
     *
     * @throws InvalidPaymentMethod
     */
    protected function setConfig(array $config): void
    {
        // set hyperpay environment
        $this->setEnvironment();

        // set hyperpay endpoint
        $this->endpoint = $this->isTestMode ? 'https://eu-test.oppwa.com' : 'https://oppwa.com';

        // set hyperpay access token
        $this->accessToken = $this->isTestMode ? config('hyperpay.config.test.access_token') : config('hyperpay.config.live.access_token');

        // set base configurations
        $config['currency'] = $config['currency'] ?? config('hyperpay.config.currency');
        $config['paymentType'] = config('hyperpay.config.payment_type');

        // set company details
        $config['billing'] = [
            'street1' => config('hyperpay.config.company.street1'),
            'street2' => config('hyperpay.config.company.street2'),
            'city' => config('hyperpay.config.company.city'),
            'state' => config('hyperpay.config.company.state'),
            'postcode' => config('hyperpay.config.company.postcode'),
            'country' => config('hyperpay.config.company.country'),
        ];

        // set core hyperpay configurations
        $this->config = $config;

        // set hyperpay entity
        $this->config['entityId'] = $this->getHyperPayEntity();
    }

    /**
     * get target hyperpay entity
     *
     * @throws InvalidPaymentMethod
     */
    protected function getHyperPayEntity(): string
    {
        // HyperPay Test Mode Entity
        $testEntity = match ($this->config['payment_method']) {
            'VISA' => config('hyperpay.config.test.visa'),
            'MASTER' => config('hyperpay.config.test.master_card'),
            'MADA' => config('hyperpay.config.test.mada'),
            'APPLEPAY' => config('hyperpay.config.test.apple_pay'),
            'GOOGLEPAY' => config('hyperpay.config.test.google_pay'),
            default => throw new InvalidPaymentMethod('Payment Method Not Found')
        };

        // HyperPay Live Mode Entity
        $liveEntity = match ($this->config['payment_method']) {
            'VISA' => config('hyperpay.config.live.visa'),
            'MASTER' => config('hyperpay.config.live.master_card'),
            'MADA' => config('hyperpay.config.live.mada'),
            'APPLEPAY' => config('hyperpay.config.live.apple_pay'),
            'GOOGLEPAY' => config('hyperpay.config.live.google_pay'),
            default => throw new InvalidPaymentMethod('Payment Method Not Found')
        };

        return $this->isTestMode ? $testEntity : $liveEntity;
    }

    /**
     * render config to hyperpay configurations recursive array.
     */
    private function arrayRecursive(array $config): array
    {
        $config = new RecursiveIteratorIterator(new RecursiveArrayIterator($config));
        $result = [];
        foreach ($config as $values) {
            $keys = [];
            foreach (range(0, $config->getDepth()) as $depth) {
                $keys[] = $config->getSubIterator($depth)->key();
            }
            $result[implode('.', $keys)] = $values;
        }

        return $result;
    }

    /**
     * get checkout mapped configurations.
     */
    public function checkoutConfig(): array
    {
        $config = $this->arrayRecursive(
            config: $this->config,
        );

        // unset Payment Method
        Arr::forget($config, 'payment_method');

        return $config;
    }

    /**
     * render config to hyperpay status array.
     */
    public function paymentStatusConfig(): array
    {
        return ['entityId' => $this->config['entityId']];
    }

    /**
     * render config to hyperpay report array.
     */
    public function paymentReportConfig(): array
    {
        return ['entityId' => $this->config['entityId']];
    }

    /**
     * render config to hyperpay settlement array.
     */
    public function settlementReportConfig(): array
    {
        // Set HyperPay Settlement Report Dummy Data
        if ($this->isTestMode) {
            $this->config['testMode'] = 'INTERNAL';
        }

        $config = self::arrayRecursive(
            config: $this->config,
        );

        return Arr::only($config, ['entityId', 'date.from', 'date.to', 'currency', 'testMode']);
    }

    /**
     * render config to hyperpay refund array.
     */
    public function refundConfig(): array
    {
        $this->config['paymentType'] = 'RF';

        return Arr::only($this->config, ['entityId', 'paymentType', 'amount', 'currency']);
    }

    /**
     * render config to hyperpay reverse array.
     */
    public function reverseConfig(): array
    {
        $this->config['paymentType'] = 'RV';

        return Arr::only($this->config, ['entityId']);
    }

    /**
     * validate hyperpay status.
     */
    protected function validateStatus(string $resultCode): bool
    {
        $successCodePattern = '/^(000\.000\.|000\.100\.1|000\.[36])/';
        $successManualReviewCodePattern = '/^(000\.400\.0|000\.400\.100)/';

        return preg_match($successCodePattern, $resultCode) || preg_match($successManualReviewCodePattern, $resultCode);
    }

    /**
     * validate checkout status
     * to ensure that checkout form has been created.
     */
    protected function validateCheckout(string $resultCode): bool
    {
        return preg_match('/^(000\.200)/', $resultCode);
    }
}
