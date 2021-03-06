<?php namespace Pantono\Orders\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Order
 * @package Pantono\Orders\Entity
 * @ORM\Entity
 * @ORM\Table(name="order")
 */
class Order extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $billingContact;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $shippingContact;
    /**
     * @ORM\Column(type="string")
     */
    protected $reference;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $total;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $vat;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $delivery;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $discount;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Orders\Entity\Status")
     */
    protected $status;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Session\Entity\Session")
     */
    protected $session;
    /**
     * @ORM\Column(type="integer")
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
