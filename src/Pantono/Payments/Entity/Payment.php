<?php namespace Pantono\Payments\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Payment
 *
 * @package Pantono\Payments\Entity
 * @ORM\Entity
 * @ORM\Table(name="payment")
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Payments\Entity\Method")
     */
    protected $method;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;
    /**
     * @ORM\Column(type="decimal", scale=2, precision=10)
     */
    protected $amount;
    /**
     * @ORM\Column(type="decimal", length=1)
     */
    protected $approved = false;
}