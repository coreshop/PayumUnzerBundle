# CoreShop Unzer (formerly known as heidelpay) Payum Connector
This Bundle activates the Unzer PaymentGateway in CoreShop.
It requires the [coreshop/payum-unzer](https://github.com/coreshop/payum-unzer) repository which will be installed automatically.

## Notice
The Unzer Payum Implementation currently only supports following gateways:
 - PayPal
 - Klarna Sofort
 - Credit Card
 - Debit Card

## Installation

#### 1. Composer
```json
"require": {
    "coreshop/payum-unzer-bundle": "^1.0"
}
```

#### 2. Installation via Extension Manager
Enable the Bundle in Pimcore Extension Manager or Installation via CommandLine:
 - Execute: $ bin/console pimcore:bundle:enable UnzerBundle
 - Execute: $ bin/console pimcore:bundle:install UnzerBundle

#### 3. Setup
Go to Coreshop -> PaymentProvider and add a new Provider. Choose `unzer` from `type` and fill out the required fields.

