<?php namespace Pantono\Locale\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Country
 * @package Pantono\Locale\Entity
 * @ORM\Entity
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
     * @ORM\Column(type="text")
     */
    protected $name;
    /**
     * @ORM\Column(type="text", length=2)
     */
    protected $countryCodeShort;
    /**
     * @ORM\Column(type="text", length=3)
     */
    protected $countryCodeLong;
    /**
     * @ORM\Column(type="integer")
     */
    protected $countryCodeNumeric;
    /**
     * @ORM\Column(type="text")
     */
    protected $currencySymbol;

    /**
     * @ORM\ManyToOne(targetEntity="Currency")
     */
    protected $currency;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCountryCodeShort()
    {
        return $this->countryCodeShort;
    }

    /**
     * @param mixed $countryCodeShort
     */
    public function setCountryCodeShort($countryCodeShort)
    {
        $this->countryCodeShort = $countryCodeShort;
    }

    /**
     * @return mixed
     */
    public function getCountryCodeLong()
    {
        return $this->countryCodeLong;
    }

    /**
     * @param mixed $countryCodeLong
     */
    public function setCountryCodeLong($countryCodeLong)
    {
        $this->countryCodeLong = $countryCodeLong;
    }

    /**
     * @return mixed
     */
    public function getCountryCodeNumeric()
    {
        return $this->countryCodeNumeric;
    }

    /**
     * @param mixed $countryCodeNumeric
     */
    public function setCountryCodeNumeric($countryCodeNumeric)
    {
        $this->countryCodeNumeric = $countryCodeNumeric;
    }

    /**
     * @return mixed
     */
    public function getCurrencySymbol()
    {
        return $this->currencySymbol;
    }

    /**
     * @param mixed $currencySymbol
     */
    public function setCurrencySymbol($currencySymbol)
    {
        $this->currencySymbol = $currencySymbol;
    }
}
