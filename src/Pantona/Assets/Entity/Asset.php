<?php

namespace Pantona\Assets\Entity;

/**
 * Class Asset
 *
 * @package Pantona\Assets\Entity
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
     * @ManyToOne(targetEntity="Pantona\Assets\Entity\Type")
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
