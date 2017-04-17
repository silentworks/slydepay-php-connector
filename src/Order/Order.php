<?php

namespace Slydepay\Order;

use Slydepay\Helper;

class Order
{
    private $orderCodeOrId;
    private $subTotal;
    private $shippingCost;
    private $taxAmount;
    private $total;
    private $description;
    private $comment;
    private $orderItems = [];

    /**
     * Order constructor.
     * @param $orderCodeOrId unique order code or id when null is passed an GUID is generated from Helper Class
     * @param $subTotal order subtotal without any other cost associated
     * @param $shippingCost order shipping cost if there is any.It will be added to total cost. Null can be passed
     * @param $taxAmount order tax if applicable. It will be added to total cost. Null can be passed
     * @param $description known as comment1 on slydepay API,can provide description to show to customer
     * @param $comment known as comment2 on slydepay API, can provide further details on order
     * @param array $orderItems list of items purchased to be paid for by customer
     */
    public function __construct($orderCodeOrId = null,
                                $shippingCost = null,
                                $taxAmount = null,
                                $description = null,
                                $comment = null,
                                OrderItems $orderItems)
    {
        $this->orderCodeOrId = Helper::isNullOrEmptyString($orderCodeOrId)? Helper::getGUIDString(): $orderCodeOrId;
        $this->subTotal = $orderItems->subTotal();
        $this->shippingCost = $shippingCost;
        $this->taxAmount = $taxAmount;
        $this->total = $orderItems->subTotal() + $shippingCost + $taxAmount;
        $this->description = $description;
        $this->comment = $comment;
        $this->orderItems = $orderItems;
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

    /**
     * @return mixed
     */
    public function getOrderCodeOrId()
    {
        return $this->orderCodeOrId;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return array
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    public function total()
    {
        return $this->total;
    }
}