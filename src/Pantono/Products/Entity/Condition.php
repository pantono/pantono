<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Condition
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity(repositoryClass="Pantono\Products\Entity\Repository\ProductRepository")
 * @ORM\Table(name="product_condition")
 */
class Condition
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
}
