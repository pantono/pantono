<?php

namespace Csburton\SilEcom\Products\Entity;

/**
 * Class File
 *
 * @package SilEcom\Products\Entity
 * @Entity
 * @Table(name="product_file")
 */
class File
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Products\Entity\Draft")
     */
    protected $product_draft;
    /**
     * @Column(type="integer")
     */
    protected $display_order;
}
