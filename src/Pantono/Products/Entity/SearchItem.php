<?php

namespace Pantono\Products\Entity;

/**
 * Class SearchItem
 *
 * @package Pantono\Products\Entity
 * @Entity
 * @Table(name="product_search_item")
 */
class SearchItem
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantono\Products\Entity\Search")
     */
    protected $search;
    /**
     * @Column(type="string")
     */
    protected $brands;
    /**
     * @Column(type="string")
     */
    protected $sku;
    /**
     * @var int
     * @Column(type="integer")
     */
    protected $minPrice = 0;
    /**
     * @var int
     * @Column(type="integer")
     */
    protected $maxPrice = 0;
    /**
     * @Column(type="string")
     */
    protected $categories;
}
