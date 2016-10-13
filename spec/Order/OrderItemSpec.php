<?php
describe("OrderItem", function () {
    it("should return subtotal for item with a quantity of 1", function () {
        $item = new Slydepay\Order\OrderItem('SLYDE:1203920', 'Item One', 5, 1);
        expect($item->subTotal())->toBe(5);
    });

    it("should return subtotal for item with a quantity of 4", function () {
        $item = new Slydepay\Order\OrderItem('SLYDE:1203920', 'Item One', 5, 4);
        expect($item->subTotal())->toBe(20);
    });
});