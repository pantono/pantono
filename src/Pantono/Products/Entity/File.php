<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class File
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity
 * @ORM\Table(name="product_file")
 */
class File extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Products\Entity\Draft")
     */
    protected $productDraft;
    /**
     * @ORM\Column(type="integer")
     */
    protected $displayOrder;
}
