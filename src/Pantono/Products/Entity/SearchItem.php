<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SearchItem
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity
 * @ORM\Table(name="product_search_item")
 */
class SearchItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Products\Entity\Search")
     */
    protected $search;
    /**
     * @ORM\Column(type="string")
     */
    protected $brands;
    /**
     * @ORM\Column(type="string")
     */
    protected $sku;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $minPrice = 0;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $maxPrice = 0;
    /**
     * @ORM\Column(type="string")
     */
    protected $categories;
}
