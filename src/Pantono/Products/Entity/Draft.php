<?php

namespace Pantono\Products\Entity;

/**
 * Class Draft
 *
 * @package Pantono\Products\Entity
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
     * @OneToMany(targetEntity="Product", mappedBy="id")
     */
    protected $product;
    /**
     * @OneToMany(targetEntity="Pantono\Suppliers\Entity\Supplier", mappedBy="id")
     */
    protected $supplier;
    /**
     * @OneToMany(targetEntity="Condition", mappedBy="id")
     */
    protected $condition;
    /**
     * @OneToMany(targetEntity="Brand", mappedBy="id")
     */
    protected $brand;
    /**
     * @OneToMany(targetEntity="Pantono\Acl\Entity\AdminUser", mappedBy="id")
     */
    protected $adminUser;
    /**
     * @Column(type="string")
     */
    protected $urlKey;
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
     * @OneToMany(targetEntity="Gallery", mappedBy="product_draft")
     */
    protected $gallery;
    /**
     * @OneToMany(targetEntity="File", mappedBy="product_draft")
     */
    protected $files;


    /**
     * @OneToMany(targetEntity="Variation", mappedBy="draft")
     */
    protected $variations;

    /**
     * @Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param mixed $supplier
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param mixed $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getAdminUser()
    {
        return $this->adminUser;
    }

    /**
     * @param mixed $adminUser
     */
    public function setAdminUser($adminUser)
    {
        $this->adminUser = $adminUser;
    }

    /**
     * @return mixed
     */
    public function getUrlKey()
    {
        return $this->urlKey;
    }

    /**
     * @param mixed $urlKey
     */
    public function setUrlKey($urlKey)
    {
        $this->urlKey = $urlKey;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param mixed $ean
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param mixed $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return Variation[]
     */
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * @param mixed $variations
     */
    public function setVariations($variations)
    {
        $this->variations = $variations;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }
}
