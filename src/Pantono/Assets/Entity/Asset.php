<?php

namespace Pantono\Assets\Entity;

/**
 * Class Asset
 *
 * @package Pantono\Assets\Entity
 * @Entity
 * @Table(name="asset")
 */
class Asset
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantono\Assets\Entity\Type")
     */
    protected $type;
    /**
     * @Column(type="string")
     */
    protected $filename;
    /**
     * @Column(type="integer")
     */
    protected $filesize;
    /**
     * @Column(type="string")
     */
    protected $mimeType;
    /**
     * @Column(type="string")
     */
    protected $publicUrl;
}
