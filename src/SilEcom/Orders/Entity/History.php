<?php

namespace SilEcom\Orders\Entity;

class History
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $order;
    protected $status;
    protected $comment;
    protected $admin_user;
    protected $email;
}