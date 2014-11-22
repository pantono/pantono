<?php

namespace SilEcom\Products\Entity;

class Condition
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $name;
}
