<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Gallery
 *
 * @package Pantono\Products
 * @ORM\Entity
 * @ORM\Table(name="product_gallery")
 */
class Gallery extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="Pantono\Products\Entity\Draft")
     */
    protected $productDraft;
    /**
     * @ORM\OneToOne(targetEntity="Pantono\Assets\Entity\Asset")
     */
    protected $asset;
    /**
     * @ORM\Column(type="integer")
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
