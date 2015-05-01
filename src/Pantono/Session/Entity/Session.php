<?php

namespace Pantono\Session\Entity;

/**
 * Class Session
 *
 * @package Pantono\Session\Entity
 * @Entity
 * @Table(name="session")
 */
class Session
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
    protected $sessionId;
    /**
     * @Column(type="string")
     */
    protected $userAgent;
    /**
     * @Column(type="datetime")
     */
    protected $lastAction;
    /**
     * @ManyToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;

    /**
     * @ManyToOne(targetEntity="Pantono\Acl\Entity\AdminUser")
     */
    protected $adminUser;
}
