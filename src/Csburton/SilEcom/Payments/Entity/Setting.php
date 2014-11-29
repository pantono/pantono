<?php

namespace Csburton\SilEcom\Payments\Entity;

/**
 * Class Method
 *
 * @package SilEcom\Payments\Entity
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
     * @ManyToOne(targetEntity="Csburton\SilEcom\Payments\Entity\Method")
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