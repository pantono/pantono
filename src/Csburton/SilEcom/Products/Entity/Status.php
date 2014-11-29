<?php

namespace Csburton\SilEcom\Products\Entity;

/**
 * Class Status
 *
 * @package SilEcom\Products\Entity
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
