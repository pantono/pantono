<?php

namespace Pantona\Assets\Entity;

/**
 * Class Resized
 *
 * @package Pantona\Assets\Entity
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
     * @ManyToOne(targetEntity="Pantona\Assets\Entity\Asset")
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
    protected $publicUrl;
}
