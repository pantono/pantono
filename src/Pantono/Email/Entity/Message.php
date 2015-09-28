<?php namespace Pantono\Email\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Message
 *
 * @package Pantono\Email\Entity
 * @ORM\Entity
 * @ORM\Table(name="email_message")
 */
class Message extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $subject;
    /**
     * @ORM\Column(type="text")
     */
    protected $htmlContent;
    /**
     * @ORM\Column(type="text")
     */
    protected $plainTextContent;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;
    /**
     * @ORM\Column(type="string")
     */
    protected $fromName;
    /**
     * @ORM\Column(type="string")
     */
    protected $fromEmail;

    /**
     * @ORM\OneToMany(targetEntity="Pantono\Email\Entity\QueueItem", mappedBy="message")
     */
    protected $messages;
}
