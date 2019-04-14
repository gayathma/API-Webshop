<?php

namespace App\Omnipay\SuperPay\Message;

use Omnipay\Common\Message\AbstractRequest as AbstractRequest;

/**
 * Class PurchaseRequest
 */
class PurchaseRequest extends AbstractRequest
{

    /**
     * Live or Test Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://superpay.view.agentur-loop.com/pay';

    /**
     * Sets the request email.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * Get the request email.
     * @return $this
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * Sets the request order.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setOrder($value)
    {
        return $this->setParameter('order', $value);
    }

    /**
     * Get the request order.
     * @return $this
     */
    public function getOrder()
    {
        return $this->getParameter('order');
    }

    /**
     * Sets the request value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        return $this->setParameter('value', $value);
    }

    /**
     * Get the request value.
     * @return $this
     */
    public function getValue()
    {
        return $this->getParameter('value');
    }

    /**
     * Prepare data to send
     * @return array
     */
    public function getData()
    {
        $this->validate('order', 'email', 'value');

        return [
            'order_id'        => $this->getOrder(),
            'customer_email'  => $this->getEmail(),
            'value'           => $this->getValue()
        ];
    }

    public function sendRequest($data)
    {

        $httpRequest = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic bG9vcDpiYWNrZW5kX2Rldg==',
            ],
            !empty($data) ? json_encode($data) : null
        );
        return $httpRequest;
    }

    /**
     * Send data and return response instance
     *
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface|\Omnipay\Idram\Message\PurchaseResponse
     */
    public function sendData($data)
    {

        $httpResponse = $this->sendRequest($data);

        return $this->response = new PurchaseResponse($this, $httpResponse);
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getEndpoint()
    {
        return $this->liveEndpoint;
    }
}