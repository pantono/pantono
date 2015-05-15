<?php namespace Pantono\Contacts\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Contact
 *
 * @package Pantono\Contacts\Entity
 * @ORM\Entity(repositoryClass="Repository\ContactRepository")
 * @ORM\Table(name="contact")
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
     * @ORM\ManyToOne(targetEntity="Contact")
     */
    protected $title;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Customers\Entity\Customer")
     */
    protected $customer;
    /**
     * @ORM\OneToOne(targetEntity="Address")
     */
    protected $address;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phoneLandline;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phoneMobile;
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dateCreated;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPhoneLandline()
    {
        return $this->phoneLandline;
    }

    /**
     * @param mixed $phoneLandline
     */
    public function setPhoneLandline($phoneLandline)
    {
        $this->phoneLandline = $phoneLandline;
    }

    /**
     * @return mixed
     */
    public function getPhoneMobile()
    {
        return $this->phoneMobile;
    }

    /**
     * @param mixed $phoneMobile
     */
    public function setPhoneMobile($phoneMobile)
    {
        $this->phoneMobile = $phoneMobile;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }
}
