<?php namespace Pantono\Customers\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Contact
 *
 * @package Pantono\Customers\Entity
 * @ORM\Entity
 * @ORM\Table(name="customer_contact")
 */
class Contact extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;

    /**
     * @ORM\OneToOne(targetEntity="Pantono\Contacts\Entity\Contact")
     */
    protected $contact;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $billingContact = false;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $deliveryContact = false;
}
