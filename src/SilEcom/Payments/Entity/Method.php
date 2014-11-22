<?php

namespace SilEcom\Payments\Entity;

class Method
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $name;
    protected $gateway_method_call;
}