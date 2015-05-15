<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Pricing
 * @package Pantono\Products\Entity
 * @ORM\Entity
 * @ORM\Table(name="product_pricing")
 */
class Pricing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Variation")
     */
    protected $variation;
    /**
     * @ORM\OneToMany(targetEntity="VatStatus", mappedBy="id")
     */
    protected $vatStatus;
    /**
     * @ORM\Column(type="decimal", scale=2, precision=10)
     */
    protected $price;
    /**
     * @ORM\Column(type="decimal", scale=2, precision=10)
     */
    protected $deliveryAmount;
    /**
     * @ORM\Column(type="decimal", scale=2, precision=10)
     */
    protected $rrp;
    /**
     * @ORM\Column(type="integer")
     */
    protected $minQty;
    /**
     * @ORM\Column(type="integer")
     */
    protected $maxQty;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getVariation()
    {
        return $this->variation;
    }

    /**
     * @param mixed $variation
     */
    public function setVariation($variation)
    {
        $this->variation = $variation;
    }

    /**
     * @return mixed
     */
    public function getVatStatus()
    {
        return $this->vatStatus;
    }

    /**
     * @param mixed $vatStatus
     */
    public function setVatStatus($vatStatus)
    {
        $this->vatStatus = $vatStatus;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDeliveryAmount()
    {
        return $this->deliveryAmount;
    }

    /**
     * @param mixed $deliveryAmount
     */
    public function setDeliveryAmount($deliveryAmount)
    {
        $this->deliveryAmount = $deliveryAmount;
    }

    /**
     * @return mixed
     */
    public function getRrp()
    {
        return $this->rrp;
    }

    /**
     * @param mixed $rrp
     */
    public function setRrp($rrp)
    {
        $this->rrp = $rrp;
    }

    /**
     * @return mixed
     */
    public function getMinQty()
    {
        return $this->minQty;
    }

    /**
     * @param mixed $minQty
     */
    public function setMinQty($minQty)
    {
        $this->minQty = $minQty;
    }

    /**
     * @return mixed
     */
    public function getMaxQty()
    {
        return $this->maxQty;
    }

    /**
     * @param mixed $maxQty
     */
    public function setMaxQty($maxQty)
    {
        $this->maxQty = $maxQty;
    }
}