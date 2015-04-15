<?php

namespace Pantona\Products\Entity;

/**
 * Class Search
 *
 * @package Pantona\Products\Entity
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
     * @OneToMany(targetEntity="Pantona\Products\Entity\SearchItem", mappedBy="search")
     */
    protected $items;
}
