<?php namespace Pantono\Payments\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Method
 *
 * @package Pantono\Payments\Entity
 * @ORM\Entity
 * @ORM\Table(name="payment_setting")
 */
class Setting
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
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @ORM\Column(type="string")
     */
    protected $value;

}