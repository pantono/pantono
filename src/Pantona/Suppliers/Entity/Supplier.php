<?php

namespace Pantona\Suppliers\Entity;

/**
 * Class Supplier
 *
 * @package Pantona\Suppliers\Entity
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
     * @OneToMany(targetEntity="Pantona\Suppliers\Entity\Contact", mappedBy="supplier")
     */
    protected $contacts;
}
