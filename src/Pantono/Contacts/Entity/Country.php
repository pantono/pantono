<?php

namespace Pantono\Contacts\Entity;

/**
 * Class Country
 *
 * @package Pantono\Contacts\Entity
 * @Entity(repositoryClass="Repository\ContactRepository")
 * @Table(name="country")
 */
class Country
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @Column(type="string")
     */
    protected $fullName;
    /**
     * @Column(type="string", length=2)
     */
    protected $iso2Letter;
    /**
     * @Column(type="string", length=3)
     */
    protected $iso3Letter;
}
