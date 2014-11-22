<?php

namespace SilEcom\Email\Entity;

/**
 * Class QueueItem
 *
 * @package SilEcom\Email\Entity
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
     * @ManyToOne(targetEntity="SilEcom\Email\Entity\Message")
     */
    protected $message;
    /**
     * @Column(type="string")
     */
    protected $to_email;
    /**
     * @Column(type="string")
     */
    protected $to_name;
    /**
     * @Column(type="integer", length=1)
     */
    protected $processed = false;
    /**
     * @Column(type="datetime")
     */
    protected $date_processed;
    /**
     * @Column(type="integer", length=1)
     */
    protected $success = false;
}
