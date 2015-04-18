<?php

namespace Pantono\Suppliers\Entity;

/**
 * Class Contact
 *
 * @package Pantono\Suppliers\Entity
 * @Entity
 * @Table(name="supplier_contact")
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
     * @ManyToOne(targetEntity="Pantono\Suppliers\Entity\Supplier")
     */
    protected $supplier;
    /**
     * @OneToOne(targetEntity="Pantono\Contacts\Entity\Contact")
     */
    protected $contact;
    /**
     * @Column(type="integer", length=1)
     */
    protected $billingContact = 0;
    /**
     * @Column(type="integer", length=1)
     */
    protected $mainContact = 0;
}
