<?php

namespace Pantona\Orders\Entity;

/**
 * Class Status
 * @package Pantona\Orders\Entity
 * @Entity
 * @Table(name="order_status")
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
    /**
     * @Column(type="integer")
     */
    protected $displayOrder;
}