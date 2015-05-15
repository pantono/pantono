<?php namespace Pantono\Orders\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Status
 * @package Pantono\Orders\Entity
 * @ORM\Entity
 * @ORM\Table(name="order_status")
 */
class Status
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
     * @ORM\Column(type="integer")
     */
    protected $displayOrder;
}