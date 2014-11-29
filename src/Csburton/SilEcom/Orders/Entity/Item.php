<?php

namespace Csburton\SilEcom\Orders\Entity;

/**
 * Class Item
 * @package SilEcom\Orders\Entity
 * @Entity
 * @Table(name="order_item")
 */
class Item
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Orders\Entity\Order")
     */
    protected $order;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Products\Entity\Product")
     */
    protected $product;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Products\Entity\Draft")
     */
    protected $product_draft;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Products\Entity\Variation")
     */
    protected $product_variant;

    /**
     * @Column(type="integer", scale=10, precision=2)
     */
    protected $price;
    /**
     * @Column(type="integer", scale=10, precision=2)
     */
    protected $vat;
    /**
     * @Column(type="integer", scale=10, precision=2)
     */
    protected $delivery;
}