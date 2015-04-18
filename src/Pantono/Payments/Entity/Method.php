<?php

namespace Pantono\Payments\Entity;

/**
 * Class Method
 *
 * @package Pantono\Payments\Entity
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
    protected $gatewayMethodCall;
    /**
     * @OneToMany(targetEntity="Pantono\Payments\Entity\Setting", mappedBy="method")
     */
    protected $settings;
}