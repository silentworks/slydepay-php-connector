<?php

use Slydepay\Order\OrderItem;
use Slydepay\Order\OrderItems;

describe("OrderItems", function () {
    it("should have at least one order item", function () {
        $orderItems = new OrderItems([
            new OrderItem('MP1234', 'Mango', 2, 1)
        ]);
        expect($orderItems->count())->toBeGreaterThan(0);
    });

    it("should give a subtotal of all items", function () {
        $orderItems = new OrderItems([
            new OrderItem('OR1234', 'Orange', 5, 2),
            new OrderItem('MP1234', 'Mango', 8, 1),
        ]);
        expect($orderItems->subTotal())->toBe(18);
    });

    it("should return an list of order items", function () {
        $items = [
            new OrderItem('OR1234', 'Orange', 5, 2),
            new OrderItem('MP1234', 'Mango', 8, 1),
        ];
        $orderItems = new OrderItems($items);
        expect($orderItems->toArray())->toBeA('array')->toBe($items);
    });
});