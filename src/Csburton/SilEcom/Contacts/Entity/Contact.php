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
}
