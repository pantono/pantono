<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pantono\Database\Entity\EntityAbstract;

/**
 * Class Draft
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity
 * @ORM\Table(name="product_draft")
 */
class Draft extends EntityAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="id")
     */
    protected $product;
    /**
     * @ORM\OneToMany(targetEntity="Pantono\Suppliers\Entity\Supplier", mappedBy="id")
     */
    protected $supplier;
    /**
     * @ORM\OneToMany(targetEntity="Condition", mappedBy="id")
     */
    protected $condition;
    /**
     * @ORM\OneToMany(targetEntity="Brand", mappedBy="id")
     */
    protected $brand;

    /**
     * @ORM\ManyToMany(targetEntity="Pantono\Categories\Entity\Category")
     */
    protected $categories;
    /**
     * @ORM\OneToMany(targetEntity="Pantono\Acl\Entity\AdminUser", mappedBy="id")
     */
    protected $adminUser;
    /**
     * @ORM\Column(type="string")
     */
    protected $urlKey;
    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    /**
     * @ORM\Column(type="string")
     */
    protected $sku;
    /**
     * @ORM\Column(type="string")
     */
    protected $ean;
    /**
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     * @ORM\OneToMany(targetEntity="Gallery", mappedBy="product_draft")
     */
    protected $gallery;
    /**
     * @ORM\OneToMany(targetEntity="File", mappedBy="product_draft")
     */
    protected $files;


    /**
     * @ORM\OneToMany(targetEntity="Variation", mappedBy="draft")
     */
    protected $variations;

    /**
     * @ORM\Column(type="datetime")
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

    /**
     * @return \Pantono\Categories\Entity\Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function getCategoryString()
    {
        $cats = [];
        foreach ($this->getCategories() as $category) {
            $cats[] = $category->getTitle();
        }
        return implode(', ', $cats);
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getPriceMinMax()
    {
        return ['min' => $this->getPriceMin(), 'max' => $this->getPriceMax()];
    }

    public function getPriceMin()
    {
        $min = 0;
        foreach ($this->getVariations() as $variation) {
            if ($variation->getMinPrice() <= $min || $min == 0) {
                $min = $variation->getMinPrice();
            }
        }
        return $min;
    }

    public function getPriceMax()
    {
        $max = 0;
        foreach ($this->getVariations() as $variation)
        {
            if ($variation->getMaxPrice() > $max || $max == 0) {
                $max = $variation->getMaxPrice();
            }
        }
        return $max;
    }

}
