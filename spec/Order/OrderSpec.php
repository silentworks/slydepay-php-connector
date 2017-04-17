<?php

use Slydepay\Order\Order;
use Slydepay\Order\OrderItems;
use Slydepay\Order\OrderItem;

describe("Order", function () {
    it("should return the Order properties", function () {

        $orderItems = new OrderItems([
            new OrderItem('OR1234', 'Orange', 5, 2),
            new OrderItem('MP1234', 'Mango', 8, 1),
        ]);

        $actualArray = [
            [
                'ItemCode' => 'OR1234',
                'ItemName' => 'Orange',
                'UnitPrice' => 5,
                'Quantity' => 2,
                'SubTotal' => 10
            ],
            [
                'ItemCode' => 'MP1234',
                'ItemName' => 'Mango',
                'UnitPrice' => 8,
                'Quantity' => 1,
                'SubTotal' => 8
            ],
        ];

        $order = new Order("order_id_1",12,10,null,null,$orderItems);

        expect($order->getOrderCodeOrId())->toBe("order_id_1");
        expect($order->subTotal())->toBe(18);
        expect($order->shippingCost())->toBe(12);
        expect($order->taxAmount())->toBe(10);
        expect($order->total())->toBe(40);
        expect($order->getDescription())->toBeNull();
        expect($order->getComment())->toBeNull();
        expect($order->getOrderItems())->toBeA('object');
        expect($order->getOrderItems()->toArray(true))->toBeA('array')->toBe($actualArray);
    });

    it("should return the Order properties ", function () {

        $orderItems = new OrderItems([
            new OrderItem('OR1234', 'Orange', 5, 2),
            new OrderItem('MP1234', 'Mango', 8, 1),
        ]);

        $actualArray = [
            [
                'ItemCode' => 'OR1234',
                'ItemName' => 'Orange',
                'UnitPrice' => 5,
                'Quantity' => 2,
                'SubTotal' => 10
            ],
            [
                'ItemCode' => 'MP1234',
                'ItemName' => 'Mango',
                'UnitPrice' => 8,
                'Quantity' => 1,
                'SubTotal' => 8
            ],
        ];

        $order = new Order(null,12,10,"description",null,$orderItems);

        expect($order->getOrderCodeOrId())->not->toBeNull();
        expect($order->getOrderCodeOrId())->toMatch('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i');
        expect($order->subTotal())->toBe(18);
        expect($order->shippingCost())->toBe(12);
        expect($order->taxAmount())->toBe(10);
        expect($order->total())->toBe(40);
        expect($order->getDescription())->not->toBeNull()->toBe("description");
        expect($order->getComment())->toBeNull();
        expect($order->getOrderItems())->toBeA('object');
        expect($order->getOrderItems()->toArray(true))->toBeA('array')->toBe($actualArray);
    });
});