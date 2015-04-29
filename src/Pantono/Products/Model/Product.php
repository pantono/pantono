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
        $prices = $this->getAllPrices();
        return array_shift($prices);
    }


    public function getPriceMax()
    {
        $prices = $this->getAllPrices();
        return array_pop($prices);
    }

    public function getAllPrices()
    {
        $prices = [];
        foreach ($this->product->getDraft()->getVariations() as $variation) {
            foreach ($variation->getPricing() as $price) {
                if ($price->getPrice() > 0) {
                    $prices[] = $price->getPrice();
                }
            }
        }
        usort($prices, function ($a, $b) {
            if ($a == $b) return 0;
            return $a > $b;
        });
        return $prices;
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