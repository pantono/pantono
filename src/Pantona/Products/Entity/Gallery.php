<?php

namespace Pantona\Products\Entity;

/**
 * Class Gallery
 *
 * @package Pantona\Products
 * @Entity
 * @Table(name="product_gallery")
 */
class Gallery
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Pantona\Products\Entity\Draft")
     */
    protected $productDraft;
    /**
     * @OneToOne(targetEntity="Pantona\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @Column(type="integer")
     */
    protected $displayOrder;

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
    public function getProductDraft()
    {
        return $this->productDraft;
    }

    /**
     * @param mixed $productDraft
     */
    public function setProductDraft($productDraft)
    {
        $this->productDraft = $productDraft;
    }

    /**
     * @return mixed
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * @param mixed $asset
     */
    public function setAsset($asset)
    {
        $this->asset = $asset;
    }

    /**
     * @return mixed
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * @param mixed $displayOrder
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;
    }
}
