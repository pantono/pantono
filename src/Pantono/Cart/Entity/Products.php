<?php namespace Pantono\Cart\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Products
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity
 * @ORM\Table(name="cart_products")
 */
class Products extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Products\Entity\Product")
     */
    protected $product;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Products\Entity\Variation")
     */
    protected $variant;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Cart\Entity\Cart")
     */
    protected $cart;
    /**
     * @ORM\Column(type="string")
     */
    protected $quantity;
    /**
     * @ORM\Column(type="decimal", scale=2, precision=10)
     */
    protected $price;
    /**
     * @ORM\Column(type="decimal", scale=2, precision=10)
     */
    protected $vat;
}
