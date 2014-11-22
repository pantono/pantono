<?php

namespace SilEcom\Orders\Entity;

/**
 * Class Order
 * @package SilEcom\Orders\Entity
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
     * @OneToOne(targetEntity="SilEcom\Customers\Entity\Customer")
     */
    protected $customer;
    /**
     * @OneToOne(targetEntity="SilEcom\Customers\Entity\Customer")
     */
    protected $billing_contact;
    /**
     * @OneToOne(targetEntity="SilEcom\Customers\Entity\Customer")
     */
    protected $shipping_contact;
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
     * @ManyToOne(targetEntity="SilEcom\Orders\Entity\Status")
     */
    protected $status;
    /**
     * @ManyToOne(targetEntity="SilEcom\Core\Entity\Session")
     */
    protected $session;
    /**
     * @Column(type="integer")
     */
    protected $paid;
}