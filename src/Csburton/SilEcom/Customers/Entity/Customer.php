<?php

namespace Csburton\SilEcom\Customers\Entity;

/**
 * Class Customer
 *
 * @package SilEcom\Customers\Entity
 * @Entity
 * @Table(name="customer")
 */
class Customer
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @Column(type="string")
     */
    protected $name;
    /**
     * @Column(type="string")
     */
    protected $company_name;

    /**
     * @OneToMany(targetEntity="Csburton\SilEcom\Customers\Entity\Contact", mappedBy="id")
     */
    protected $contacts;
}