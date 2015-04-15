<?php

namespace Pantona\Payments\Entity;

/**
 * Class Method
 *
 * @package Pantona\Payments\Entity
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
     * @OneToMany(targetEntity="Pantona\Payments\Entity\Setting", mappedBy="method")
     */
    protected $settings;
}