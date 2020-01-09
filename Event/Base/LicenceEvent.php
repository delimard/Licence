<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace Licence\Event\Base;

use Thelia\Core\Event\ActionEvent;
use Licence\Model\Licence;

/**
* Class LicenceEvent
* @package Licence\Event\Base
* @author TheliaStudio
*/
class LicenceEvent extends ActionEvent
{
    protected $id;
    protected $orderId;
    protected $customerId;
    protected $productId;
    protected $productKey;
    protected $activeMachine;
    protected $expirationDate;
    protected $licence;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    public function getProductKey()
    {
        return $this->productKey;
    }

    public function setProductKey($productKey)
    {
        $this->productKey = $productKey;

        return $this;
    }

    public function getActiveMachine()
    {
        return $this->activeMachine;
    }

    public function setActiveMachine($activeMachine)
    {
        $this->activeMachine = $activeMachine;

        return $this;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getLicence()
    {
        return $this->licence;
    }

    public function setLicence(Licence $licence)
    {
        $this->licence = $licence;

        return $this;
    }
}
