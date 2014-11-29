<?php

namespace Csburton\SilEcom\Products\Entity;

/**
 * Class Gallery
 *
 * @package SilEcom\Products
 * @Entity
 * @Table(name="product_gallery")
 */
class Gallery
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Products\Entity\Draft")
     */
    protected $product_draft;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @Column(type="integer")
     */
    protected $display_order;
}
