<?php

namespace Csburton\SilEcom\Contacts\Entity;

/**
 * Class Contact
 *
 * @package SilEcom\Contacts\Entity
 * @Entity
 * @Table(name="contact")
 */
class Contact
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Customers\Entity\Customer")
     */
    protected $customer;
    /**
     * @Column(type="string")
     */
    protected $first_name;
    /**
     * @Column(type="string")
     */
    protected $last_name;
    /**
     * @Column(type="string")
     */
    protected $email;
    /**
     * @Column(type="integer")
     */
    protected $email_verified = 0;
    /**
     * @Column(type="string")
     */
    protected $address_line_1;
    /**
     * @Column(type="string")
     */
    protected $address_line_2;
    /**
     * @Column(type="string")
     */
    protected $address_line_3;
    /**
     * @Column(type="string")
     */
    protected $town;
    /**
     * @Column(type="string")
     */
    protected $county;
    /**
     * @Column(type="string")
     */
    protected $phone_landline;
    /**
     * @Column(type="string")
     */
    protected $phone_mobile;
    /**
     * @Column(type="datetime")
     */
    protected $date_created;
    /**
     * @ManyToOne(targetEntity="Csburton\SilEcom\Contacts\Entity\Country")
     */
    protected $country;

    /**
     * @return mixed
     */
    public function getAddressLine1()
    {
        return $this->address_line_1;
    }

    /**
     * @param mixed $address_line_1
     */
    public function setAddressLine1($address_line_1)
    {
        $this->address_line_1 = $address_line_1;
    }

    /**
     * @return mixed
     */
    public function getAddressLine2()
    {
        return $this->address_line_2;
    }

    /**
     * @param mixed $address_line_2
     */
    public function setAddressLine2($address_line_2)
    {
        $this->address_line_2 = $address_line_2;
    }

    /**
     * @return mixed
     */
    public function getAddressLine3()
    {
        return $this->address_line_3;
    }

    /**
     * @param mixed $address_line_3
     */
    public function setAddressLine3($address_line_3)
    {
        $this->address_line_3 = $address_line_3;
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
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param mixed $date_created
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmailVerified()
    {
        return $this->email_verified;
    }

    /**
     * @param mixed $email_verified
     */
    public function setEmailVerified($email_verified)
    {
        $this->email_verified = $email_verified;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

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
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getPhoneLandline()
    {
        return $this->phone_landline;
    }

    /**
     * @param mixed $phone_landline
     */
    public function setPhoneLandline($phone_landline)
    {
        $this->phone_landline = $phone_landline;
    }

    /**
     * @return mixed
     */
    public function getPhoneMobile()
    {
        return $this->phone_mobile;
    }

    /**
     * @param mixed $phone_mobile
     */
    public function setPhoneMobile($phone_mobile)
    {
        $this->phone_mobile = $phone_mobile;
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
}
