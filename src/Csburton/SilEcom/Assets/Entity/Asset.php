<?php

namespace Csburton\SilEcom\Assets\Entity;

/**
 * Class Asset
 *
 * @package SilEcom\Assets\Entity
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
     * @ManyToOne(targetEntity="Csburton\SilEcom\Assets\Entity\Type")
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
    protected $mime_type;
    /**
     * @Column(type="string")
     */
    protected $public_url;
}
