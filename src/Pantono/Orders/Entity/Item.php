<?php namespace Pantono\Orders\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Item
 * @package Pantono\Orders\Entity
 * @ORM\Entity
 * @ORM\Table(name="order_item")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Orders\Entity\Order")
     */
    protected $order;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Products\Entity\Product")
     */
    protected $product;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Products\Entity\Draft")
     */
    protected $productDraft;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Products\Entity\Variation")
     */
    protected $productVariant;

    /**
     * @ORM\Column(type="integer", scale=10, precision=2)
     */
    protected $price;
    /**
     * @ORM\Column(type="integer", scale=10, precision=2)
     */
    protected $vat;
    /**
     * @ORM\Column(type="integer", scale=10, precision=2)
     */
    protected $delivery;

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
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getProductDraft()
    {
        return $this->productDraft;
    }

    /**
     * @param mixed $productDraft
     */
    public function setProductDraft($productDraft)
    {
        $this->productDraft = $productDraft;
    }

    /**
     * @return mixed
     */
    public function getProductVariant()
    {
        return $this->productVariant;
    }

    /**
     * @param mixed $productVariant
     */
    public function setProductVariant($productVariant)
    {
        $this->productVariant = $productVariant;
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
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param mixed $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * @return mixed
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @param mixed $delivery
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;
    }
}
