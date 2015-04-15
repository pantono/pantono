<?php

namespace Pantona\Products\Entity;

/**
 * Class Condition
 *
 * @package Pantona\Products\Entity
 * @Entity
 * @Table(name="product_condition")
 */
class Condition
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
