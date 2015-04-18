<?php

namespace Pantono\Suppliers\Entity;

/**
 * Class Supplier
 *
 * @package Pantono\Suppliers\Entity
 * @Entity
 * @Table(name="supplier")
 */
class Supplier
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
    protected $companyName;
    /**
     * @Column(type="integer", length=1)
     */
    protected $active;
    /**
     * @OneToMany(targetEntity="Pantono\Suppliers\Entity\Contact", mappedBy="supplier")
     */
    protected $contacts;
}
