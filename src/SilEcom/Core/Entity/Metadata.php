<?php

namespace SilEcom\Core\Entity;

/**
 * Class Metadata
 *
 * @package SilEcom\Suppliers\Entity
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
    protected $page_title;
    /**
     * @Column(type="string")
     */
    protected $meta_description;
    /**
     * @Column(type="string")
     */
    protected $meta_keywords;
    /**
     * @Column(type="string")
     */
    protected $meta_robots;
    /**
     * @Column(type="string")
     */
    protected $meta_canonical;
    /**
     * @Column(type="string")
     */
    protected $navigation_title;
}
