<p align="center"><a href="https://www.hyperpay.com" target="_blank"><img src="https://www.hyperpay.com/wp-content/uploads/2022/10/Hyperpay-logo-svg-1.png" alt="HyperPay" width="200"></a></p>


### About HyperPay
THE E-PAYMENT GATEWAY
WORLD-CLASS TECHNOLOGY LOCAL EXPERTISE

### Features
- COPY&PAY Integration.
- One-Click Checkout.
- Tokenization Checkout.
- Transaction Reports.
- Settlement Reports.
- Backoffice Operations [ Refund - Reverse ].

### Installation

```bash
composer require hossammonir/hyperpay
```

<p>Publish repository configurations</p>

```bash
php artisan vendor:publish --provider="HossamMonir\HyperPay\HyperPayServiceProvider"
```

<p>This will publish hyperpay.php configurations to config/hyperpay.php</p>

<br /><br />
#### Prepare Environment

Add the following configuration to **.env** file .

```bash
HYPERPAY_TEST_MODE=true #switch to false in production
HYPERPAY_CURRENCY="SAR" #default currency
HYPERPAY_PAYMENT_TYPE="DB" #default payment type

# Live Credentials
HYPERPAY_LIVE_ACCESS_TOKEN="your-live-access-token"
HYPERPAY_LIVE_VISA_ENTITY="your-live-visa-entity"
HYPERPAY_LIVE_MASTERCARD_ENTITY="your-live-mastercard-entity"
HYPERPAY_LIVE_MADA_ENTITY="your-live-mada-entity"
HYPERPAY_LIVE_APPLEPAY_ENTITY="your-live-applepay-entity"
HYPERPAY_LIVE_GOOGLEPAY_ENTITY="your-live-googlepay-entity"


# Test Credentials
HYPERPAY_TEST_ACCESS_TOKEN="your-test-access-token"
HYPERPAY_TEST_VISA_ENTITY="your-test-visa-entity"
HYPERPAY_TEST_MASTERCARD_ENTITY="your-test-mastercard-entity"
HYPERPAY_TEST_MADA_ENTITY="your-test-mada-entity"
HYPERPAY_TEST_APPLEPAY_ENTITY="your-test-applepay-entity"
HYPERPAY_TEST_GOOGLEPAY_ENTITY="your-test-googlepay-entity"

# Optional ( Merchant Details )
HYPERPAY_COMPANY_NAME="your-company-name"
HYPERPAY_COMPANY_STREET1="your-company-street1"
HYPERPAY_COMPANY_STREET2="your-company-street2"
HYPERPAY_COMPANY_CITY="your-company-city"
HYPERPAY_COMPANY_STATE="your-company-state"
HYPERPAY_COMPANY_COUNTRY="your-company-country"
HYPERPAY_COMPANY_POSTCODE="your-company-postal-code"
```

### Usage

#### Prepare Payment

* Prepare checkout form with basic setup.

```php
    use HossamMonir\HyperPay\Facades\HyperPay;
    use HossamMonir\HyperPay\Enums\HyperPayPaymentMethod;
    use HossamMonir\HyperPay\Data\Customer;

        HyperPay::setAmount('100.50') // amount must match ^[0-9]{1,12}(\\.[0-9]{2})?$ 
        ->setMethod(HyperPayPaymentMethod::VISA)
        ->setCurrency('SAR')
        ->setTransactionId('123123123') // your should create unique transaction id for each payment
        ->setCustomer(new Customer(
            givenName: 'Hossam',
            surname: 'Monir',
            mobile: '966500000000',
            email: 'hey@digitaltunnel.net', // optional
            merchantCustomerId: '123456789', // optional
        ))
        ->basicCheckout();
```

* Example Response
    
```json
{

    "response": {
        "result": {
            "code": "000.200.100",
            "description": "successfully created checkout"
        },
        "buildNumber": "8fa7d731df54352cbb412a410148592d9e5f1ae2@2023-04-13 11:54:02 +0000",
        "timestamp": "2023-04-14 02:33:49+0000",
        "ndc": "053979FB5110C62F73DB32BBDB4D65C9.uat01-vm-tx04",
        "id": "053979FB5110C62F73DB32BBDB4D65C9.uat01-vm-tx04"
    },
    "props": {
        "merchant_transaction_id": "123123123",
        "payment_method": "VISA",
        "test_mode": true,
        "endpoint": "https://eu-test.oppwa.com",
        "script_url": "https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId=053979FB5110C62F73DB32BBDB4D65C9.uat01-vm-tx04",
        "currency": "SAR",
        "amount": "100.50",
        "status": {
            "success": true,
            "message": "successfully created checkout"
        }
    }

}
```

to be continued...
