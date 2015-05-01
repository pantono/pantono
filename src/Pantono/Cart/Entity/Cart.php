<?php

namespace Pantono\Cart\Entity;

/**
 * Class Cart
 *
 * @package Pantono\Cart\Entity
 * @Entity
 * @Table(name="cart")
 */
class Cart
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @OneToOne(targetEntity="Pantono\Session\Entity\Session")
     */
    protected $session;
    /**
     * @ManyToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;
    /**
     * @Column(type="datetime")
     */
    protected $dateCreated;
    /**
     * @Column(type="datetime")
     */
    protected $dateUpdated;
}
