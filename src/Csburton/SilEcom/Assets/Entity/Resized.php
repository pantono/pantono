<?php

namespace Csburton\SilEcom\Assets\Entity;

/**
 * Class Resized
 *
 * @package SilEcom\Assets\Entity
 * @Entity
 * @Table(name="asset_resized")
 */
class Resized
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @Column(type="integer")
     */
    protected $width;
    /**
     * @Column(type="integer")
     */
    protected $height;
    /**
     * @Column(type="string")
     */
    protected $public_url;
}
