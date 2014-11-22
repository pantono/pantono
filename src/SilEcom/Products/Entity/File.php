<?php

namespace SilEcom\Products\Entity;

class File
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $product;
    protected $asset;
    protected $display_order;
}
