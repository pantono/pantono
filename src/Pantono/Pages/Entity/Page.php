<?php namespace Pantono\Pages\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Page
 *
 * @package Pantono\Pages\Entity
 * @ORM\Entity
 * @ORM\Table(name="page")
 */
class Page extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\OneToMany(targetEntity="Pantono\Pages\Entity\Page", mappedBy="id")
     */
    protected $draft;
    /**
     * @ORM\Column(type="integer")
     */
    protected $status;
}
