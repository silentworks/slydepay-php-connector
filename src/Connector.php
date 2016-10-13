<?php

namespace Slydepay;

use Slydepay\Exception\ProcessPayment;
use Slydepay\Order\OrderAmount;
use Slydepay\Order\OrderItems;
use SoapClient;
use SoapHeader;

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

        $soapHeader = new SoapHeader($this->namespace, "PaymentHeader", $headers);
        $this->soap->__setSoapHeaders($soapHeader);
    }

    public function processPaymentOrder(
        $orderId, 
        $description,
        OrderAmount $orderAmount, 
        OrderItems $orderItems, 
        $comment = null
    ) {
        try {
            $params = [
                'orderId' => $orderId,
                'subtotal' => $orderAmount->subTotal(),
                'shippingCost' => $orderAmount->shippingCost(),
                'taxAmount' => $orderAmount->taxAmount(),
                'total' => $orderAmount->total(),
                'comment1' => $description,
                'comment2' => $comment,
                'orderItems' => $orderItems->toArray(),
            ];
            $response = $this->soap->ProcessPaymentOrder($params);
            return new ApiResponse($response->ProcessPaymentOrderResult);
        } catch (\Exception $e) {
            throw new ProcessPayment($e);
        }
    }

    public function confirmTransaction($payToken, $transactionId)
    {
        try {
            $params = [
                'payToken' => $payToken,
                'transactionId' => $transactionId,
            ];

            return $this->soap->ConfirmTransaction($params);
        } catch (Exception $e) {
            // die silently
        }
    }

    public function cancelTransaction($payToken, $transactionId)
    {
        try {
            $params = [
                'payToken' => $payToken,
                'transactionId' => $transactionId,
            ];

            return $this->soap->CancelTransaction($params);
        } catch (Exception $e) {
            // die silently
        }
    }
}
