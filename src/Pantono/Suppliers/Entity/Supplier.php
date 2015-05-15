<?php namespace Pantono\Suppliers\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Supplier
 *
 * @package Pantono\Suppliers\Entity
 * @ORM\Entity
 * @ORM\Table(name="supplier")
 */
class Supplier
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
    protected $companyName;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $active;
    /**
     * @ORM\OneToMany(targetEntity="Pantono\Suppliers\Entity\Contact", mappedBy="supplier")
     */
    protected $contacts;
}
