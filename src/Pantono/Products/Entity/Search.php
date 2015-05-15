<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Search
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity
 * @ORM\Table(name="product_search")
 */
class Search
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;
    /**
     * @ORM\OneToMany(targetEntity="Pantono\Products\Entity\SearchItem", mappedBy="search")
     */
    protected $items;
}
