<?php

namespace Pantono\Email\Entity;

/**
 * Class QueueItem
 *
 * @package Pantono\Email\Entity
 * @Entity
 * @Table(name="email_queue_item")
 */
class QueueItem
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantono\Email\Entity\Message")
     */
    protected $message;
    /**
     * @Column(type="string")
     */
    protected $toEmail;
    /**
     * @Column(type="string")
     */
    protected $toName;
    /**
     * @Column(type="integer", length=1)
     */
    protected $processed = false;
    /**
     * @Column(type="datetime")
     */
    protected $dateProcessed;
    /**
     * @Column(type="integer", length=1)
     */
    protected $success = false;
}
