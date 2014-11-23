<?php

namespace SilEcom\Products\Entity;

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
     * @ManyToOne(targetEntity="SilEcom\Products\Entity\Draft")
     */
    protected $product_draft;
    /**
     * @OneToOne(targetEntity="SilEcom\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @Column(type="integer")
     */
    protected $display_order;
}
