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
     * @OneToMany(targetEntity="SilEcom\Products\Entity\Product", mappedBy="id")
     */
    protected $product;
    /**
     * @OneToMany(targetEntity="SilEcom\Suppliers\Entity\Supplier", mappedBy="id")
     */
    protected $supplier;
    /**
     * @OneToMany(targetEntity="SilEcom\Products\Entity\Condition", mappedBy="id")
     */
    protected $condition;
    /**
     * @OneToMany(targetEntity="SilEcom\Products\Entity\Brand", mappedBy="id")
     */
    protected $brand;
    /**
     * @OneToMany(targetEntity="SilEcom\Acl\Entity\AdminUser", mappedBy="id")
     */
    protected $admin_user;
    /**
     * @Column(type="string")
     */
    protected $url_key;
    /**
     * @Column(type="string")
     */
    protected $title;
    /**
     * @Column(type="string")
     */
    protected $sku;
    /**
     * @Column(type="string")
     */
    protected $ean;
    /**
     * @Column(type="text")
     */
    protected $description;
    /**
     * @OneToMany(targetEntity="SilEcom\Products\Entity\VatStatus", mappedBy="id")
     */
    protected $vat_status;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $price;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $delivery_amount;
    /**
     * @Column(type="decimal", scale=2, precision=10)
     */
    protected $rrp;
    /**
     * @OneToMany(targetEntity="SilEcom\Products\Entity\Gallery", mappedBy="product_draft")
     */
    protected $gallery;
    /**
     * @OneToMany(targetEntity="SilEcom\Products\Entity\File", mappedBy="product_draft")
     */
    protected $files;
}
