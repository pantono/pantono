<?php

namespace Csburton\SilEcom\Suppliers\Entity;

/**
 * Class Contact
 *
 * @package SilEcom\Suppliers\Entity
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
     * @ManyToOne(targetEntity="Csburton\SilEcom\Suppliers\Entity\Supplier")
     */
    protected $supplier;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Contacts\Entity\Contact")
     */
    protected $contact;
    /**
     * @Column(type="integer", length=1)
     */
    protected $billing_contact = 0;
    /**
     * @Column(type="integer", length=1)
     */
    protected $main_contact = 0;
}
