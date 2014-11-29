<?php

namespace Csburton\SilEcom\Categories\Entity;

/**
 * Class Category
 *
 * @package SilEcom\Contacts\Entity
 * @Entity
 * @Table(name="category")
 */
class Category
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Categories\Entity\Category")
     */
    protected $parent;
    /**
     * @Column(type="integer")
     */
    protected $status;
    /**
     * @Column(type="string")
     */
    protected $title;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Assets\Entity\Asset")
     */
    protected $image;
    /**
     * @Column(type="string", length=50, unique=true)
     */
    protected $url_key;
    /**
     * @OneToOne(targetEntity="Csburton\SilEcom\Core\Entity\Metadata")
     */
    protected $metadata;
}
