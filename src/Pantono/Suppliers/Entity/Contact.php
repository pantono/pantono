<?php namespace Pantono\Suppliers\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 *
 * @package Pantono\Suppliers\Entity
 * @ORM\Entity
 * @ORM\Table(name="supplier_contact")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Suppliers\Entity\Supplier")
     */
    protected $supplier;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Contacts\Entity\Contact")
     */
    protected $contact;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $billingContact = 0;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $mainContact = 0;
}
