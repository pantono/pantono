<?php

namespace SilEcom\Products\Entity;

class SearchItem
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $search;
    protected $brands;
    protected $sku;
    protected $min_price = 0;
    protected $max_price = 0;
    protected $categories;
}
