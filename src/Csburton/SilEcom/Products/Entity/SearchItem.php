<?php

namespace Csburton\SilEcom\Products\Entity;

/**
 * Class SearchItem
 *
 * @package SilEcom\Products\Entity
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
     * @ManyToOne(targetEntity="Csburton\SilEcom\Products\Entity\Search")
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
    protected $min_price = 0;
    /**
     * @var int
     * @Column(type="integer")
     */
    protected $max_price = 0;
    /**
     * @Column(type="string")
     */
    protected $categories;
}
