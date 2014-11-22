<?php

namespace SilEcom\Products\Entity;

/**
 * Class Variation
 *
 * @package SilEcom\Products\Entity
 * @Entity
 * @Table(name="product_variation")
 */
class Variation
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="SilEcom\Products\Entity\Draft")
     */
    protected $product_draft;
    /**
     * @Column(type="string")
     */
    protected $title;
    /**
     * @Column(type="string")
     */
    protected $sku;
    /**
     * @Column(type="decimal", precision=10, scale=2)
     */
    protected $price;
}
