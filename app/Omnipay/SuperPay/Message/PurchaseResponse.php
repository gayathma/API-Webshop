<?php
namespace App\Omnipay\SuperPay\Message;

use Omnipay\Common\Message\AbstractResponse;
/**
 * Class PurchaseResponse
 */
class PurchaseResponse extends AbstractResponse
{

    /**
     * Return response status
     * @return bool
     */
    public function isSuccessful()
    {
        return ($this->data->getStatusCode() == 200);
    }
}