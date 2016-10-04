<?php

namespace Slydepay;

use SoapClient;

class Connector
{
    private $soap;
    private $namespace = 'http://www.i-walletlive.com/payLIVE';
    private $wsdl = 'https://app.slydepay.com.gh/webservices/paymentservice.asmx?wsdl';
    private $version = '1.4';

    /**
     * @param string  $merchantEmail
     * @param string  $merchantSecretKey
     * @param string  $serviceType
     * @param boolean $integrationMode  set to true when in development mode, set to false for live mode
     */
    public function __construct($merchantEmail, $merchantSecretKey, $serviceType = 'C2B', $integrationMode = true)
    {
        $this->soap = new SoapClient($this->wsdl);
        $headers = [
            'APIVersion' => $this->version,
            'MerchantEmail' => $merchantEmail,
            'MerchantKey' => $merchantSecretKey,
            'SvcType' => $serviceType,
            'UseIntMode' => $integrationMode,
        ];
        $this->soap->__setSoapHeaders($this->namespace, "PaymentHeader", $headers);
    }

    public function processPaymentOrder($orderId, $subTotal, $shippingCost, $taxAmount, $total, $comment1, $comment2 = null, array $orderItems)
    {
        try {
            $params = [
                'orderId' => $orderId,
                'subtotal' => $subTotal,
                'shippingCost' => $shippingCost,
                'taxAmount' => $taxAmount,
                'total' => $total,
                'comment1' => $comment1,
                'comment2' => $comment2,
                'orderItems' => $orderItems
            ];
            return $this->soap->ProcessPaymentOrder($params);
        } catch (\Exception $e) {
            // die silently
        }
    }
}
