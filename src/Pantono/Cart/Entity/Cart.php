<?php namespace Pantono\Cart\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cart
 *
 * @package Pantono\Cart\Entity
 * @ORM\Entity
 * @ORM\Table(name="cart")
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Session\Entity\Session")
     */
    protected $session;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateUpdated;
}
