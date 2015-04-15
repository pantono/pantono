<?php

namespace Pantona\Categories\Entity;

/**
 * Class Category
 *
 * @package Pantona\Contacts\Entity
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
     * @ManyToOne(targetEntity="Pantona\Categories\Entity\Category")
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
     * @OneToOne(targetEntity="Pantona\Assets\Entity\Asset")
     */
    protected $image;
    /**
     * @Column(type="string", length=50, unique=true)
     */
    protected $urlKey;
    /**
     * @OneToOne(targetEntity="Pantona\Core\Entity\Metadata")
     */
    protected $metadata;
}
