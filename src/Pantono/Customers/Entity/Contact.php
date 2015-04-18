<?php

namespace Pantono\Customers\Entity;

/**
 * Class Contact
 *
 * @package Pantono\Customers\Entity
 * @Entity
 * @Table(name="customer_contact")
 */
class Contact
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;

    /**
     * @OneToOne(targetEntity="Pantono\Contacts\Entity\Contact")
     */
    protected $contact;
    /**
     * @Column(type="integer", length=1)
     */
    protected $billingContact = false;
    /**
     * @Column(type="integer", length=1)
     */
    protected $deliveryContact = false;
}