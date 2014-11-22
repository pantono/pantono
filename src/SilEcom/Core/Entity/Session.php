<?php

namespace SilEcom\Core\Entity;

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
     * @OneToMany(targetEntity="SilEcom\Customers\Entity\Customer", mappedBy="id")
     */
    protected $customer;

    protected $admin_user;
}
