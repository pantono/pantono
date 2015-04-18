<?php namespace Pantono\Products\Entity;

/**
 * Class Pricing
 * @package Pantono\Products\Entity
 * @Entity
 * @Table(name="product_pricing")
 */
class Pricing
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Variation")
     */
    protected $variation;
    /**
     * @OneToMany(targetEntity="VatStatus", mappedBy="id")
     */
    protected $vatStatus;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $price;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $deliveryAmount;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $rrp;
    /**
     * @Column(type="integer")
     */
    protected $minQty;
    /**
     * @Column(type="integer")
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