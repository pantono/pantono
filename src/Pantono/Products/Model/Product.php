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
        $min = $max = 0;
        $variations = $this->product->getDraft()->getVariations();
        foreach ($variations as $variation) {
            $prices = $variation->getPricing();
            foreach ($prices as $price) {
                if ($min === 0 || $price->getPrice() <= $min && intval($price->getPrice()) > 0) {
                    $min = $price->getPrice();
                }
                if ($max === 0 || $price->getPrice() > $max && intval($price->getPrice()) > 0) {
                    $max = $price->getPrice();
                }
            }
        }
        return ['min' => $min, 'max' => $max];
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
                if ($min === 0 || $price->getPrice() < $min) {
                    $min = $price->getPrice();
                }
                if ($max === 0 || $price->getPrice() > $max) {
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