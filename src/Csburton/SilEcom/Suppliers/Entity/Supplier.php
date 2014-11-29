<?php

namespace Csburton\SilEcom\Suppliers\Entity;

/**
 * Class Supplier
 *
 * @package SilEcom\Suppliers\Entity
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
    protected $company_name;
    /**
     * @Column(type="integer", length=1)
     */
    protected $active;
    /**
     * @OneToMany(targetEntity="Csburton\SilEcom\Suppliers\Entity\Contact", mappedBy="supplier")
     */
    protected $contacts;
}
