<?php

namespace SilEcom\Customers\Entity;

/**
 * Class Contact
 *
 * @package SilEcom\Customers\Entity
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
     * @ManyToOne(targetEntity="SilEcom\Customers\Entity\Customer")
     */
    protected $customer;

    /**
     * @OneToOne(targetEntity="SilEcom\Contacts\Entity\Contact")
     */
    protected $contact;
    /**
     * @Column(type="integer", length=1)
     */
    protected $billing_contact = false;
    /**
     * @Column(type="integer", length=1)
     */
    protected $delivery_contact = false;
}