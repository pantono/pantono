<?php

namespace Csburton\SilEcom\Email\Entity;

/**
 * Class Message
 *
 * @package SilEcom\Email\Entity
 * @Entity
 * @Table(name="email_message")
 */
class Message
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
    protected $subject;
    /**
     * @Column(type="text")
     */
    protected $html_content;
    /**
     * @Column(type="text")
     */
    protected $plain_text_content;
    /**
     * @Column(type="datetime")
     */
    protected $date_created;
    /**
     * @Column(type="string")
     */
    protected $from_name;
    /**
     * @Column(type="string")
     */
    protected $from_email;

    /**
     * @OneToMany(targetEntity="Csburton\SilEcom\Email\Entity\QueueItem", mappedBy="message")
     */
    protected $messages;
}
