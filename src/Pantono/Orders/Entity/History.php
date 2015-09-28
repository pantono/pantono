<?php namespace Pantono\Orders\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class History
 * @package Pantono\Orders\Entity
 * @ORM\Entity
 * @ORM\Table(name="order_history")
 */
class History extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Orders\Entity\Order")
     */
    protected $order;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Orders\Entity\Status")
     */
    protected $status;
    /**
     * @ORM\Column(type="string")
     */
    protected $comment;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Acl\Entity\AdminUser")
     */
    protected $adminUser;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Email\Entity\Message")
     */
    protected $email;
}
