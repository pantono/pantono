<?php

namespace Pantono\Products\Entity;

/**
 * Class Status
 *
 * @package Pantono\Products\Entity
 * @Entity
 * @Table(name="product_status")
 */
class Status
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
    protected $name;
}
