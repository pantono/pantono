<?php

namespace SilEcom\Payments\Entity;

class Payment
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $method;
    protected $date;
    protected $amount;
    protected $approved;
}