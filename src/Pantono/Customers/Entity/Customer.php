<?php

namespace Pantono\Customers\Entity;

/**
 * Class Customer
 *
 * @package Pantono\Customers\Entity
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
    protected $companyName;

    /**
     * @OneToMany(targetEntity="Pantono\Customers\Entity\Contact", mappedBy="customer")
     */
    protected $contacts;

    /**
     * @Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @Column(type="string")
     */
    protected $password;
}