<?php

namespace SilEcom\Products\Entity;

/**
 * Class Draft
 *
 * @package SilEcom\Products\Entity
 * @Entity
 * @Table(name="product_draft")
 */
class Draft
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="SilEcom\Products\Entity\Product")
     */
    protected $product;
    protected $supplier;
    protected $condition;
    protected $brand;
    protected $admin_user;
    protected $url_key;
    protected $title;
    protected $sku;
    protected $ean;
    protected $description;
    protected $vat_status;
    protected $price;
    protected $delivery_amount;
    protected $rrp;
    protected $gallery;
    protected $files;
}
