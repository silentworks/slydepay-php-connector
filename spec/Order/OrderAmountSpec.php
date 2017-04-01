<?php

use Slydepay\Order\OrderAmount;

describe("OrderAmount", function () {
    it("should return the OrderAmount properties", function () {
        $amount = new OrderAmount(40, 12, 10);
        expect($amount->subTotal())->toBe(40);
        expect($amount->shippingCost())->toBe(12);
        expect($amount->taxAmount())->toBe(10);
        expect($amount->total())->toBe(62);
    });
});