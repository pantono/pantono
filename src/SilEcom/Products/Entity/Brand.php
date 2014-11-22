<?php

namespace SilEcom\Products\Entity;

class Brand
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $name;
    protected $logo;
}
