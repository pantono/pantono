<?php

namespace Pantono\Assets\Entity;

/**
 * Class Resized
 *
 * @package Pantono\Assets\Entity
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
     * @ManyToOne(targetEntity="Pantono\Assets\Entity\Asset")
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
