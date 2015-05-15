<?php namespace Pantono\Email\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class QueueItem
 *
 * @package Pantono\Email\Entity
 * @ORM\Entity
 * @ORM\Table(name="email_queue_item")
 */
class QueueItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Email\Entity\Message")
     */
    protected $message;
    /**
     * @ORM\Column(type="string")
     */
    protected $toEmail;
    /**
     * @ORM\Column(type="string")
     */
    protected $toName;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $processed = false;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateProcessed;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $success = false;
}
