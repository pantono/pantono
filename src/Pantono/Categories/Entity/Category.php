<?php

namespace Pantono\Categories\Entity;

/**
 * Class Category
 *
 * @package Pantono\Contacts\Entity
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
     * @ManyToOne(targetEntity="Pantono\Categories\Entity\Category")
     */
    protected $parent;
    /**
     * @Column(type="integer")
     */
    protected $status;
    /**
     * @Column(type="text")
     */
    protected $description;
    /**
     * @Column(type="string")
     */
    protected $title;
    /**
     * @OneToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $image;
    /**
     * @Column(type="string", length=50, unique=true)
     */
    protected $urlKey;
    /**
     * @OneToOne(targetEntity="Pantono\Core\Entity\Metadata")
     */
    protected $metadata;
}
