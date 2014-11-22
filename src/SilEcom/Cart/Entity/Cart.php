<?php

namespace SilEcom\Cart\Entity;

/**
 * Class Cart
 *
 * @package SilEcom\Cart\Entity
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
     * @OneToOne(targetEntity="SilEcom\Core\Entity\Session")
     */
    protected $session;
    /**
     * @ManyToOne(targetEntity="SilEcom\Customers\Entity\Customer")
     */
    protected $customer;
    /**
     * @Column(type="datetime")
     */
    protected $date_created;
    /**
     * @Column(type="datetime")
     */
    protected $date_updated;
}
