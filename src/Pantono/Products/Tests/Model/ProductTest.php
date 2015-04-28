<?php namespace Pantono\Products\Tests\Model;

use Pantono\Products\Model\Product;
use Pantono\Products\Tests\AbstractProductTest;

class ProductTest extends AbstractProductTest
{
    public function testGetPriceMinMaxSinglePricing()
    {
        $productEntity = $this->getDummyProduct(2);
        $productEntity->getDraft()->getVariations()[0]->getPricing()[0]->setPrice(10);
        $productEntity->getDraft()->getVariations()[1]->getPricing()[0]->setPrice(20);
        $product = new Product($productEntity);
        $this->assertEquals(['min' => 10, 'max' => 20], $product->getPriceMinMax());

        $productEntity = $this->getDummyProduct(2);
        $productEntity->getDraft()->getVariations()[0]->getPricing()[0]->setPrice(10);
        $productEntity->getDraft()->getVariations()[1]->getPricing()[0]->setPrice(10);
        $product = new Product($productEntity);
        $this->assertEquals(['min' => 10, 'max' => 10], $product->getPriceMinMax());
    }

    public function testGetPriceMinMaxMultiplePricing()
    {
        $productEntity = $this->getDummyProduct(2, 3);
        $productEntity->getDraft()->getVariations()[0]->getPricing()[0]->setPrice(10);
        $productEntity->getDraft()->getVariations()[0]->getPricing()[1]->setPrice(1);
        $productEntity->getDraft()->getVariations()[0]->getPricing()[2]->setPrice(100);
        $productEntity->getDraft()->getVariations()[1]->getPricing()[0]->setPrice(20);
        $product = new Product($productEntity);
        $this->assertEquals(['min' => 1, 'max' => 100], $product->getPriceMinMax());
    }

    public function testGetVariationCount()
    {
        $productEntity = $this->getDummyProduct(2);
        $product = new Product($productEntity);
        $this->assertEquals(2, $product->getVariationCount());

        $productEntity = $this->getDummyProduct(10);
        $product = new Product($productEntity);
        $this->assertEquals(10, $product->getVariationCount());
    }
}