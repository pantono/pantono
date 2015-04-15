<?php

namespace Pantona\Orders\Entity;

/**
 * Class History
 * @package Pantona\Orders\Entity
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
     * @ManyToOne(targetEntity="Pantona\Orders\Entity\Order")
     */
    protected $order;
    /**
     * @OneToOne(targetEntity="Pantona\Orders\Entity\Status")
     */
    protected $status;
    /**
     * @Column(type="string")
     */
    protected $comment;
    /**
     * @OneToOne(targetEntity="Pantona\Acl\Entity\AdminUser")
     */
    protected $adminUser;
    /**
     * @OneToOne(targetEntity="Pantona\Email\Entity\Message")
     */
    protected $email;
}