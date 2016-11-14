Slydepay PHP Connector
=====================

You can sign up for a Slydepay Merchant account at https://app.slydepay.com.gh/auth/signup#business_reg

## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Slydepay PHP Connector.

```bash
$ composer require slydepay/php
```

This will require Slydepay PHP and all its dependencies. Slydepay PHP required PHP 5.5 or newer.

## Usage

This is how you would process a payment with the Slydepay PHP Connector

```php
<?php

require 'vendor/autoload.php';

use Slydepay\Order\OrderAmount;
use Slydepay\Order\OrderItem;
use Slydepay\Order\OrderItems;

// Instantiate Slydepay connector
$slydepay = new Slydepay\Connector("merchantEmail", "merchantSecretKey");

// Create a list of OrderItems with OrderItem objects
$orderItems = new OrderItems([
    new OrderItem("1234", "Test Product", 10, 2),
    new OrderItem("1284", "Test Product2", 20, 2),
]);

// Create the OrderAmount for this Order
$orderAmount = new OrderAmount($orderItems->subTotal(), 20, 5);

try {
    // Make request to Slydepay and get the response object for the redirect url
    $response = $slydepay->processPaymentOrder("MO:150258398", "Test payment", $orderAmount, $orderItems);
    echo $response->redirectUrl();
} catch (Slydepay\Exception\ProcessPayment $e) {
    echo $e->getMessage();
}
```

## Tests

To execute the test suite, you'll need [kahlan](https://github.com/kahlan/kahlan).

```bash
$ kahlan
```
