<?php

namespace SilEcom\Suppliers\Entity;

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
    protected $company_name;
    protected $status;
    protected $contacts;
}
