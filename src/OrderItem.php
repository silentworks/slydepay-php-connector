<?php

namespace Slydepay;

class OrderItem
{
    protected $ItemCode;
    protected $ItemName;
    protected $UnitPrice;
    protected $Quantity;
    protected $SubTotal;

    public function __construct($itemCode, $itemName, $unitPrice, $quantity, $subTotal)
    {
        $this->ItemCode = $itemCode;
        $this->ItemName = $itemName;
        $this->UnitPrice = $unitPrice;
        $this->Quantity = $quantity;
        $this->SubTotal = $subTotal;
    }
}