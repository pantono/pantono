<?php

namespace Pantono\Core\Entity;

/**
 * Class Metadata
 *
 * @package Pantono\Suppliers\Entity
 * @Entity
 * @Table(name="metadata")
 */
class Metadata
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @Column(type="string")
     */
    protected $pageTitle;
    /**
     * @Column(type="string")
     */
    protected $metaDescription;
    /**
     * @Column(type="string")
     */
    protected $metaKeywords;
    /**
     * @Column(type="string")
     */
    protected $metaRobots;
    /**
     * @Column(type="string")
     */
    protected $metaCanonical;
    /**
     * @Column(type="string")
     */
    protected $navigationTitle;
}
