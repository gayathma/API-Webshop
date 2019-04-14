<?php

namespace App\Omnipay\SuperPay;

use Omnipay\Common\Http\ClientInterface;
use Omnipay\Common\AbstractGateway;
use App\Omnipay\SuperPay\Message\PurchaseRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * SuperPayGateway
 */
class Gateway extends AbstractGateway
{
    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return 'SuperPay';
    }

    /**
     * Gateway constructor.
     *
     * @param \Omnipay\Common\Http\ClientInterface|null      $httpClient
     * @param \Symfony\Component\HttpFoundation\Request|null $httpRequest
     */
    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        parent::__construct($httpClient, $httpRequest);
    }

    /**
     * Get default parameters
     * @return array|\Illuminate\Config\Repository|mixed
     */
    public function getDefaultParameters()
    {
        return [
            'order' => '',
            'cemail' => '',
            'value' => ''
        ];
    }

    
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
     * Get the request email
     * @return mixed
     */
    public function getEmail()
    {
        return $this->getParameter('email');
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
     * Create a purchase request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $options = array())
    {

        return $this->createRequest(PurchaseRequest::class, $options);
    }
}