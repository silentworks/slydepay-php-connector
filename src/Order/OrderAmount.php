<?php

namespace Slydepay\Order;

class OrderAmount
{
    private $subTotal;
    private $shippingCost;
    private $taxAmount;
    private $total;

    public function __construct($subTotal, $shippingCost, $taxAmount)
    {
        $this->subTotal = $subTotal;
        $this->shippingCost = $shippingCost;
        $this->taxAmount = $taxAmount;
        $this->total = $subTotal + $shippingCost + $taxAmount;
    }

    public function subTotal()
    {
        return $this->subTotal;
    }

    public function shippingCost()
    {
        return $this->shippingCost;
    }

    public function taxAmount()
    {
        return $this->taxAmount;
    }

    public function total()
    {
        return $this->total;
    }
}