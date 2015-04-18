<?php

namespace Pantono\Email\Entity;

/**
 * Class Message
 *
 * @package Pantono\Email\Entity
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
    protected $htmlContent;
    /**
     * @Column(type="text")
     */
    protected $plainTextContent;
    /**
     * @Column(type="datetime")
     */
    protected $dateCreated;
    /**
     * @Column(type="string")
     */
    protected $fromName;
    /**
     * @Column(type="string")
     */
    protected $fromEmail;

    /**
     * @OneToMany(targetEntity="Pantono\Email\Entity\QueueItem", mappedBy="message")
     */
    protected $messages;
}
