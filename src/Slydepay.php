<?php

namespace Slydepay;

use Slydepay\Exception\CancelTransaction;
use Slydepay\Exception\ConfirmTransaction;
use Slydepay\Exception\MobilePayment;
use Slydepay\Exception\ProcessPayment;
use Slydepay\Order\OrderAmount;
use Slydepay\Order\OrderItems;
use SoapClient;
use SoapHeader;

class Slydepay
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
        $this->soap = $this->newSoapClient($this->wsdl);
        $headers = [
            'APIVersion' => $this->version,
            'MerchantEmail' => $merchantEmail,
            'MerchantKey' => $merchantSecretKey,
            'SvcType' => $serviceType,
            'UseIntMode' => $integrationMode,
        ];

        $soapHeader = $this->newSoapHeader($this->namespace, $headers);
        $this->soap->__setSoapHeaders($soapHeader);
    }

    /**
     * @param string $orderId
     * @param string $description
     * @param OrderAmount $orderAmount
     * @param OrderItems $orderItems
     * @param string $comment
     *
     * @return ApiResponse
     */
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

    /**
     * @param string $orderId
     * @param string $description
     * @param OrderAmount $orderAmount
     * @param OrderItems $orderItems
     * @param string $comment
     *
     * @return ApiQrResponse
     */
    public function mobilePaymentOrder(
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
            $response = $this->soap->mobilePaymentOrder($params);
            return new ApiQrResponse($response->mobilePaymentOrderResult, $response->mobilePaymentOrderResult->token);
        } catch (\Exception $e) {
            throw new MobilePayment($e);
        }
    }

    /**
     * @param string $payToken
     * @param string $transactionId
     *
     * @return TransactionStatusResponse
     */
    public function confirmTransaction($payToken, $transactionId)
    {
        try {
            $params = [
                'payToken' => $payToken,
                'transactionId' => $transactionId,
            ];

            $response = $this->soap->ConfirmTransaction($params);
            return new TransactionStatusResponse($response->ConfirmTransactionResult);
        } catch (Exception $e) {
            throw new ConfirmTransaction($e);
        }
    }

    /**
     * @param string $payToken
     * @param string $transactionId
     *
     * @return TransactionStatusResponse
     */
    public function cancelTransaction($payToken, $transactionId)
    {
        try {
            $params = [
                'payToken' => $payToken,
                'transactionId' => $transactionId,
            ];

            $response = $this->soap->CancelTransaction($params);
            return new TransactionStatusResponse($response->CancelTransactionResult);
        } catch (Exception $e) {
            throw new CancelTransaction($e);
        }
    }

    protected function newSoapClient($wsdl)
    {
        return new SoapClient($wsdl);
    }

    protected function newSoapHeader($namespace, $headers)
    {
        return new SoapHeader($namespace, "PaymentHeader", $headers);
    }
}
