<?php

namespace Pantona\Core\Entity;

/**
 * Class Session
 *
 * @package Pantona\Core\Entity
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
     * @ManyToOne(targetEntity="Pantona\Customers\Entity\Customer")
     */
    protected $customer;

    /**
     * @ManyToOne(targetEntity="Pantona\Acl\Entity\AdminUser")
     */
    protected $adminUser;
}
