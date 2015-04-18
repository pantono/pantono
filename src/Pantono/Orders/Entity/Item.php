<?php

namespace Pantono\Orders\Entity;

/**
 * Class Item
 * @package Pantono\Orders\Entity
 * @Entity
 * @Table(name="order_item")
 */
class Item
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantono\Orders\Entity\Order")
     */
    protected $order;
    /**
     * @OneToOne(targetEntity="Pantono\Products\Entity\Product")
     */
    protected $product;
    /**
     * @OneToOne(targetEntity="Pantono\Products\Entity\Draft")
     */
    protected $productDraft;
    /**
     * @OneToOne(targetEntity="Pantono\Products\Entity\Variation")
     */
    protected $productVariant;

    /**
     * @Column(type="integer", scale=10, precision=2)
     */
    protected $price;
    /**
     * @Column(type="integer", scale=10, precision=2)
     */
    protected $vat;
    /**
     * @Column(type="integer", scale=10, precision=2)
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