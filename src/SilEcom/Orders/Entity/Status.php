<?php

namespace SilEcom\Orders\Entity;

class Status
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $name;
    protected $display_order;
}