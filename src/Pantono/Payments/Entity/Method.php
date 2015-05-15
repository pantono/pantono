<?php namespace Pantono\Payments\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Method
 *
 * @package Pantono\Payments\Entity
 * @ORM\Entity
 * @ORM\Table(name="payment_method")
 */
class Method
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
    protected $name;
    /**
     * @ORM\Column(type="string")
     */
    protected $gatewayMethodCall;
    /**
     * @ORM\OneToMany(targetEntity="Pantono\Payments\Entity\Setting", mappedBy="method")
     */
    protected $settings;
}