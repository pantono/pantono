<?php

namespace Csburton\SilEcom\Payments\Entity;

/**
 * Class Method
 *
 * @package SilEcom\Payments\Entity
 * @Entity
 * @Table(name="payment_method")
 */
class Method
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
     * @Column(type="string")
     */
    protected $gateway_method_call;
    /**
     * @OneToMany(targetEntity="Csburton\SilEcom\Payments\Entity\Setting", mappedBy="method")
     */
    protected $settings;
}