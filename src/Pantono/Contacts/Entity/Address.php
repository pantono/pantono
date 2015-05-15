<?php namespace Pantono\Contacts\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Address
 * @package Pantono\Contacts\Entity
 * @ORM\Entity(repositoryClass="Repository\ContactRepository")
 * @ORM\Table(name="address")
 */
class Address
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
    protected $addressLine1;
    /**
     * @ORM\Column(type="string")
     */
    protected $addressLine2;
    /**
     * @ORM\Column(type="string")
     */
    protected $addressLine3;
    /**
     * @ORM\Column(type="string")
     */
    protected $town;
    /**
     * @ORM\Column(type="string")
     */
    protected $county;
    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $postcode;
    /**
     * @ORM\ManyToOne(targetEntity="Country")
     */
    protected $country;

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
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @param mixed $addressLine1
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    /**
     * @return mixed
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @param mixed $addressLine2
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    /**
     * @return mixed
     */
    public function getAddressLine3()
    {
        return $this->addressLine3;
    }

    /**
     * @param mixed $addressLine3
     */
    public function setAddressLine3($addressLine3)
    {
        $this->addressLine3 = $addressLine3;
    }

    /**
     * @return mixed
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param mixed $town
     */
    public function setTown($town)
    {
        $this->town = $town;
    }

    /**
     * @return mixed
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param mixed $county
     */
    public function setCounty($county)
    {
        $this->county = $county;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
