<?php namespace Pantono\Assets\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Type
 *
 * @package Pantono\Assets\Entity
 * @ORM\Entity
 * @ORM\Table(name="asset_type")
 */
class Type extends EntityAbstract
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
    protected $type;
}
