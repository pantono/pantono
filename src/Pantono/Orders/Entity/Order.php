<?php

namespace Pantono\Orders\Entity;

/**
 * Class Order
 * @package Pantono\Orders\Entity
 * @Entity
 * @Table(name="order")
 */
class Order
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @OneToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;
    /**
     * @OneToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $billingContact;
    /**
     * @OneToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $shippingContact;
    /**
     * @Column(type="string")
     */
    protected $reference;
    /**
     * @Column(type="datetime")
     */
    protected $date;
    /**
     * @Column(type="decimal", precision=10, scale=2)
     */
    protected $total;
    /**
     * @Column(type="decimal", precision=10, scale=2)
     */
    protected $vat;
    /**
     * @Column(type="decimal", precision=10, scale=2)
     */
    protected $delivery;
    /**
     * @Column(type="decimal", precision=10, scale=2)
     */
    protected $discount;
    /**
     * @ManyToOne(targetEntity="Pantono\Orders\Entity\Status")
     */
    protected $status;
    /**
     * @ManyToOne(targetEntity="Pantono\Core\Entity\Session")
     */
    protected $session;
    /**
     * @Column(type="integer")
     */
    protected $paid;

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
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getBillingContact()
    {
        return $this->billingContact;
    }

    /**
     * @param mixed $billingContact
     */
    public function setBillingContact($billingContact)
    {
        $this->billingContact = $billingContact;
    }

    /**
     * @return mixed
     */
    public function getShippingContact()
    {
        return $this->shippingContact;
    }

    /**
     * @param mixed $shippingContact
     */
    public function setShippingContact($shippingContact)
    {
        $this->shippingContact = $shippingContact;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
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

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * @return mixed
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @param mixed $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }
}