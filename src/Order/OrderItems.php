<?php

namespace Slydepay\Order;

class OrderItems
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function subTotal()
    {
        return array_reduce($this->items, function ($carry, OrderItem $item) {
            $carry += $item->subTotal();
            return $carry;
        });
    }

    public function toArray()
    {
        return $this->items;
    }
}