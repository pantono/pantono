<?php

namespace Csburton\SilEcom\Products\Entity;

/**
 * Class Search
 *
 * @package SilEcom\Products\Entity
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
    protected $date_created;
    /**
     * @OneToMany(targetEntity="Csburton\SilEcom\Products\Entity\SearchItem", mappedBy="search")
     */
    protected $items;
}
