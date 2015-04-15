<?php

namespace Pantona\Cart\Entity;

/**
 * Class Products
 *
 * @package Pantona\Products\Entity
 * @Entity
 * @Table(name="cart_products")
 */
class Products
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantona\Products\Entity\Product")
     */
    protected $product;
    /**
     * @ManyToOne(targetEntity="Pantona\Products\Entity\Variation")
     */
    protected $variant;
    /**
     * @ManyToOne(targetEntity="Pantona\Cart\Entity\Cart")
     */
    protected $cart;
    /**
     * @Column(type="string")
     */
    protected $quantity;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $price;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $vat;
}
