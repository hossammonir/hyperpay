<?php

namespace HossamMonir\HyperPay;

use Exception;
use HossamMonir\HyperPay\Data\Customer;
use HossamMonir\HyperPay\Enums\HyperPayPaymentMethod;
use HossamMonir\HyperPay\Exceptions\InvalidPaymentMethod;
use HossamMonir\HyperPay\Services\Backoffice;
use HossamMonir\HyperPay\Services\PaymentStatus;
use HossamMonir\HyperPay\Services\PrepareCheckout;
use HossamMonir\HyperPay\Services\SettlementReport;
use HossamMonir\HyperPay\Services\TransactionReport;

class HyperPay
{
    private array $paymentMethod;

    private string $transactionId;

    private string $checkoutId;

    private string $currency;

    private array $customer;

    private array $registrations;

    private string $amount;

    private string $fromDate;

    private string $toDate;

    /**
     * Set Payment Method to ['config'].
     */
    public function setMethod(string $paymentMethod): self
    {
        $method = HyperPayPaymentMethod::tryFrom(
            value: strtoupper($paymentMethod)
        )->value;

        $this->paymentMethod = ['payment_method' => $method];

        return $this;
    }

    /**
     * Set Transaction ID to ['config'].
     */
    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Set Customer to ['config'].
     */
    public function setCustomer(Customer $customer): self
    {
        $this->customer = (array) $customer;

        return $this;
    }

    /**
     * Set Registrations to be used in the OneClick checkout.
     */
    public function setRegistrations(array $registrations): self
    {
        $this->registrations = $registrations;

        return $this;
    }

    /**
     * set currency to ['config'].
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * set amount to ['config'].
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * set checkout ID.
     */
    public function setCheckoutId(string $checkoutId): self
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    /**
     * set From Date to ['config'].
     *
     * @return $this
     */
    public function setFromDate(string $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    /**
     * Set To Date to ['config'].
     *
     * @return $this
     */
    public function setToDate(string $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * Create Checkout Request.
     *
     * @throws Exception
     */
    public function basicCheckout(): array
    {
        return (new PrepareCheckout($this->paymentMethod) )
            ->setTransactionId($this->transactionId)
            ->setAmount($this->amount)
            ->setCurrency($this->currency)
            ->setCustomer($this->customer)
            ->basicCheckout();
    }

    /**
     * Create Checkout Request.
     *
     * @throws Exception
     */
    public function checkoutWithTokenization(): array
    {
        return (new PrepareCheckout($this->paymentMethod) )
            ->setTransactionId($this->transactionId)
            ->setAmount($this->amount)
            ->setCurrency($this->currency)
            ->setCustomer($this->customer)
            ->tokenizationCheckout();
    }

    /**
     * Create Checkout Request.
     *
     * @throws Exception
     */
    public function oneClickCheckout(): array
    {
        return (new PrepareCheckout($this->paymentMethod) )
            ->setTransactionId($this->transactionId)
            ->setAmount($this->amount)
            ->setCurrency($this->currency)
            ->setRegistrations($this->registrations)
            ->oneClickCheckout();
    }

    /**
     * Validate Payment Status
     *
     * @throws Exception
     */
    public function getStatus(): array
    {
        return (new PaymentStatus($this->paymentMethod) )
            ->setCheckoutId($this->checkoutId)
            ->getStatus();
    }

    /**
     * Get Transaction Report
     *
     * @throws Exception
     */
    public function getTransactionReport(): array
    {
        return (new TransactionReport($this->paymentMethod) )
            ->setCheckoutId($this->checkoutId)
            ->getTransactionReport();
    }

    /**
     * get settlement report
     *
     * @throws InvalidPaymentMethod
     * @throws Exception
     */
    public function getSettlement(): array
    {
        return (new SettlementReport($this->paymentMethod) )
            ->setFromDate($this->fromDate)
            ->setToDate($this->toDate)
            ->getSettlement();
    }

    /**
     * refund transaction
     *
     * @throws InvalidPaymentMethod
     */
    public function refund(): array
    {
        return (new Backoffice($this->paymentMethod) )
            ->setAmount($this->amount)
            ->setCurrency($this->currency)
            ->setCheckoutId($this->checkoutId)
            ->processRefund();

    }

    /**
     * reverse transaction
     *
     * @throws InvalidPaymentMethod
     */
    public function reverse(): array
    {
        return (new Backoffice($this->paymentMethod) )
            ->setCheckoutId($this->checkoutId)
            ->processReverse();

    }
}
