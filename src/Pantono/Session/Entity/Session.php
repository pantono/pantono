<?php namespace Pantono\Session\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Session
 *
 * @package Pantono\Session\Entity
 * @ORM\Entity
 * @ORM\Table(name="session")
 */
class Session
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
    protected $sessionId;
    /**
     * @ORM\Column(type="string")
     */
    protected $userAgent;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $lastAction;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Acl\Entity\AdminUser")
     */
    protected $adminUser;
}
