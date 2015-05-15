<?php namespace Pantono\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Resized
 *
 * @package Pantono\Assets\Entity
 * @ORM\Entity
 * @ORM\Table(name="asset_resized")
 */
class Resized
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @ORM\Column(type="integer")
     */
    protected $width;
    /**
     * @ORM\Column(type="integer")
     */
    protected $height;
    /**
     * @ORM\Column(type="string")
     */
    protected $publicUrl;
}
