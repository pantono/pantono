<?php

namespace Csburton\SilEcom\Core\Entity;

/**
 * Class Session
 *
 * @package SilEcom\Core\Entity
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
    protected $session_id;
    /**
     * @Column(type="string")
     */
    protected $user_agent;
    /**
     * @Column(type="datetime")
     */
    protected $last_action;
    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Customers\Entity\Customer")
     */
    protected $customer;

    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Acl\Entity\AdminUser")
     */
    protected $admin_user;
}
