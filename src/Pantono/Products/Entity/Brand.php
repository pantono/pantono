<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Brand
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity(repositoryClass="Pantono\Products\Entity\Repository\ProductRepository")
 * @ORM\Table(name="product_brand")
 */
class Brand
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
     * @ORM\OneToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $logo;
}
