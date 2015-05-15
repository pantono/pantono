<?php namespace Pantono\Products\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Variation
 *
 * @package Pantono\Products\Entity
 * @ORM\Entity
 * @ORM\Table(name="product_variation")
 */
class Variation
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
    protected $draft;
    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    /**
     * @ORM\Column(type="string")
     */
    protected $sku;
    /**
     * @ORM\OneToMany(targetEntity="Pricing", mappedBy="variation")
     */
    protected $pricing;

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
    public function getDraft()
    {
        return $this->draft;
    }

    /**
     * @param mixed $draft
     */
    public function setDraft($draft)
    {
        $this->draft = $draft;
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
     * @return Pricing[]
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    public function getMinPrice()
    {
        $min = 0;
        foreach ($this->getPricing() as $price) {
            if ($min === 0 || $price->getPrice() <= $min) {
                $min = $price->getPrice();
            }
        }
        return $min;
    }

    public function getMaxPrice()
    {
        $max = 0;
        foreach ($this->getPricing() as $price) {
            if ($max === 0 || $price->getPrice() >= $max) {
                $max = $price->getPrice();
            }
        }
        return $max;
    }

    /**
     * @param mixed $pricing
     */
    public function setPricing($pricing)
    {
        $this->pricing = $pricing;
    }
}
