<?php

namespace Pantona\Cart\Entity;

/**
 * Class Cart
 *
 * @package Pantona\Cart\Entity
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
     * @OneToOne(targetEntity="Pantona\Core\Entity\Session")
     */
    protected $session;
    /**
     * @ManyToOne(targetEntity="Pantona\Customers\Entity\Customer")
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
