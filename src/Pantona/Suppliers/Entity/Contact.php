<?php

namespace Pantona\Suppliers\Entity;

/**
 * Class Contact
 *
 * @package Pantona\Suppliers\Entity
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
     * @ManyToOne(targetEntity="Pantona\Suppliers\Entity\Supplier")
     */
    protected $supplier;
    /**
     * @OneToOne(targetEntity="Pantona\Contacts\Entity\Contact")
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
