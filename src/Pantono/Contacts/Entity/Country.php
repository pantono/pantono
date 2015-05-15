<?php namespace Pantono\Contacts\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Country
 *
 * @package Pantono\Contacts\Entity
 * @ORM\Entity(repositoryClass="Repository\ContactRepository")
 * @ORM\Table(name="country")
 */
class Country
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
    protected $fullName;
    /**
     * @ORM\Column(type="string", length=2)
     */
    protected $iso2Letter;
    /**
     * @ORM\Column(type="string", length=3)
     */
    protected $iso3Letter;
}
