<?php

namespace SilEcom\Orders\Entity;

class Item
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    protected $order;
    protected $product;
    protected $product_draft;
    protected $product_variant;
}