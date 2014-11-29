<?php

namespace Csburton\SilEcom\Orders\Entity;

/**
 * Class History
 * @package SilEcom\Orders\Entity
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
     * @ManyToOne(targetEntity="Csburton\SilEcom\Orders\Entity\Order")
     */
    protected $order;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Orders\Entity\Status")
     */
    protected $status;
    /**
     * @Column(type="string")
     */
    protected $comment;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Acl\Entity\AdminUser")
     */
    protected $admin_user;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Email\Entity\Message")
     */
    protected $email;
}