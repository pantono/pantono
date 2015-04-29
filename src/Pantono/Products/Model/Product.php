<?php namespace Pantono\Products\Model;

class Product
{
    private $product;

    public function __construct(\Pantono\Products\Entity\Product $product)
    {
        $this->product = $product;
    }

    public function getEntity()
    {
        return $this->product;
    }

    public function isLive()
    {

    }

    /**
     * Gets min and maximum prices for product (including any variations)
     *
     * @return array ['min, 'max']
     */
    public function getPriceMinMax()
    {
        return ['min' => $this->getPriceMin(), 'max' => $this->getPriceMax()];
    }

    public function getPriceMin()
    {
        $min = 0;
        $variations = $this->product->getDraft()->getVariations();
        foreach ($variations as $variation) {
            $prices = $variation->getPricing();
            foreach ($prices as $price) {
                if ($price->getPrice() > 0) {
                    if ($min === 0) {
                        $min = $price->getPrice();
                    }
                    if ($price->getPrice() <= $min) {
                        $min = $price->getPrice();
                    }
                }
            }
        }
        return $min;
    }


    public function getPriceMax()
    {
        $max = 0;
        $variations = $this->product->getDraft()->getVariations();
        foreach ($variations as $variation) {
            $prices = $variation->getPricing();
            foreach ($prices as $price) {
                if ($price->getPrice() > 0) {
                    if ($max === 0) {
                        $max = $price->getPrice();
                    }
                    if ($price->getPrice() >= $max) {
                        $max = $price->getPrice();
                    }
                }
            }
        }
        return $max;
    }

    /**
     * Gets the minimum and maximum price for each variation
     *
     * @return array
     */
    public function getVariationMinMax()
    {
        $priceArray = [];
        $variations = $this->product->getDraft()->getVariations();
        foreach ($variations as $variation) {
            $min = $max = 0;
            $prices = $variation->getPricing();
            foreach ($prices as $price) {
                if ($price->getPrice() < $min) {
                    $min = $price->getPrice();
                }
                if ($price->getPrice() > $max) {
                    $max = $price->getPrice();
                }
            }
            $priceArray[$variation->getId()] = ['min' => $min, 'max' => $max];
        }
        return $priceArray;
    }


    /**
     * Get's number of variations in this product
     * @return int
     */
    public function getVariationCount()
    {
        return sizeof($this->product->getDraft()->getVariations());
    }
}