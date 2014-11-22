<?php

namespace SilEcom\Orders\Entity;

class Order
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $customer;
    protected $billing_contact;
    protected $shipping_contact;
    protected $reference;
    protected $date;
    protected $total;
    protected $vat;
    protected $delivery;
    protected $discount;
    protected $status;
    protected $session;
    protected $paid;
}