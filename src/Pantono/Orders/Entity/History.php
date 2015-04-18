<?php

namespace Pantono\Orders\Entity;

/**
 * Class History
 * @package Pantono\Orders\Entity
 * @Entity
 * @Table(name="order_history")
 */
class History
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantono\Orders\Entity\Order")
     */
    protected $order;
    /**
     * @OneToOne(targetEntity="Pantono\Orders\Entity\Status")
     */
    protected $status;
    /**
     * @Column(type="string")
     */
    protected $comment;
    /**
     * @OneToOne(targetEntity="Pantono\Acl\Entity\AdminUser")
     */
    protected $adminUser;
    /**
     * @OneToOne(targetEntity="Pantono\Email\Entity\Message")
     */
    protected $email;
}