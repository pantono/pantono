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
        usort($prices, function ($productA, $productB) {
            return $productA > $productB;
        });
        return $prices;
    }

    public function getAllPricesByVariation()
    {
        $prices = [];
        foreach ($this->product->getDraft()->getVariations() as $variation) {
            foreach ($variation->getPricing() as $price) {
                if ($price->getPrice() > 0) {
                    $prices[$variation->getId()] = $price->getPrice();
                }
            }
        }
        uasort($prices, function ($productA, $productB) {
            return $productA > $productB;
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
            $priceArray[$variation->getId()] = ['min' => $variation->getMinPrice(), 'max' => $variation->getMaxPrice()];
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