<?php

namespace Pantono\Products\Entity;

/**
 * Class Search
 *
 * @package Pantono\Products\Entity
 * @Entity
 * @Table(name="product_search")
 */
class Search
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
    protected $name;
    /**
     * @Column(type="datetime")
     */
    protected $dateCreated;
    /**
     * @OneToMany(targetEntity="Pantono\Products\Entity\SearchItem", mappedBy="search")
     */
    protected $items;
}
