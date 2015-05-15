<?php namespace Pantono\Products\Tests;

use Pantono\Products\Entity\Draft;
use Pantono\Products\Entity\Pricing;
use Pantono\Products\Entity\Product as ProductEntity;
use Pantono\Products\Entity\Status;
use Pantono\Products\Entity\Variation;
use Pantono\Products\Entity\VatStatus;

abstract class AbstractProductTest extends \PHPUnit_Framework_TestCase
{
    public function getDummyProduct($numVariations = 1, $prices = 1)
    {
        $product = new ProductEntity();
        $draft = new Draft();
        $variations = [];
        for ($i = 0; $i < $numVariations; $i++) {
            $variation = $this->getDummyVariation($prices);
            $variation->setDraft($draft);
            $variations[] = $variation;
        }
        $draft->setVariations($variations);
        $product->setDraft($draft);
        $product->setId(1);
        $status = new Status();
        $product->setStatus($status);
        return $product;
    }

    protected function getDummyVariation($numPrices)
    {
        $variation = new Variation();
        $vatStatus = $this->getDummyVatStatus();
        $pricingArray = [];
        for ($x = 0; $x < $numPrices; $x++) {
            $pricing = new Pricing();
            $pricing->setVatStatus($vatStatus);
            $pricing->setVariation($variation);
            $pricingArray[] = $pricing;
        }
        $variation->setPricing($pricingArray);
        return $variation;
    }

    protected function getDummyVatStatus($amount = 20, $status = 'UK VAT 20%')
    {
        $vatStatus = new VatStatus();
        $vatStatus->setAmount($amount);
        $vatStatus->setName($status);
        return $vatStatus;
    }
}
