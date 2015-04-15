<?php

namespace Pantona\Payments\Entity;

/**
 * Class Method
 *
 * @package Pantona\Payments\Entity
 * @Entity
 * @Table(name="payment_setting")
 */
class Setting
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Pantona\Payments\Entity\Method")
     */
    protected $method;
    /**
     * @Column(type="string")
     */
    protected $name;
    /**
     * @Column(type="string")
     */
    protected $value;

}