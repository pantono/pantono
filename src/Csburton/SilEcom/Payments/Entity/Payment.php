<?php

namespace Csburton\SilEcom\Payments\Entity;

/**
 * Class Payment
 *
 * @package SilEcom\Payments\Entity
 * @Entity
 * @Table(name="payment")
 */
class Payment
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
     * @Column(type="datetime")
     */
    protected $date;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $amount;
    /**
     * @Column(type="decimal", length=1)
     */
    protected $approved = false;
}