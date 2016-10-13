<?php

namespace Slydepay;

class ApiQrResponse extends Response
{
    private $response = null;
    private $token = null;

    /**
     * @param string  $response
     */
    public function __construct($response, $token = null)
    {
        $this->response = $response;
        $this->token = $token;
    }

    public function redirectUrl()
    {
        return $this->paylive . $this->response;
    }

    public function qrCode()
    {
        return $this->paylive . $this->token;
    }
}
