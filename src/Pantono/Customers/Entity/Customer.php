<?php namespace Pantono\Customers\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 *
 * @package Pantono\Customers\Entity
 * @ORM\Entity
 * @ORM\Table(name="customer")
 */
class Customer
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
     * @ORM\Column(type="string")
     */
    protected $companyName;

    /**
     * @ORM\OneToMany(targetEntity="Pantono\Customers\Entity\Contact", mappedBy="customer")
     */
    protected $contacts;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;
}
