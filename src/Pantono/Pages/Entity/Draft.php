<?php namespace Pantono\Pages\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Draft
 *
 * @package Pantono\Pages\Entity
 * @ORM\Entity
 * @ORM\Table(name="page_draft")
 */
class Draft extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Pages\Entity\Page")
     */
    protected $page;
    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    /**
     * @ORM\Column(type="text")
     */
    protected $content;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Metadata\Entity\Metadata")
     */
    protected $metadata;
}
