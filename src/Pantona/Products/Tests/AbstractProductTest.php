<?php namespace Pantona\Products\Tests;

use Pantona\Products\Entity\Draft;
use Pantona\Products\Entity\Pricing;
use Pantona\Products\Entity\Product as ProductEntity;
use Pantona\Products\Entity\Status;
use Pantona\Products\Entity\Variation;
use Pantona\Products\Entity\VatStatus;

abstract class AbstractProductTest extends \PHPUnit_Framework_TestCase
{
    public function getDummyProduct($numVariations = 1, $prices = 1)
    {
        $product = new ProductEntity();
        $draft = new Draft();
        $variations = [];
        for ($i=0;$i<$numVariations;$i++) {
            $variation = new Variation();
            $variation->setDraft($draft);
            $vatStatus = new VatStatus();
            $vatStatus->setAmount(20);
            $vatStatus->setName('UK VAT 20%');
            $pricingArray = [];
            for ($x=0;$x<$prices;$x++) {
                $pricing = new Pricing();
                $pricing->setVatStatus($vatStatus);
                $pricing->setVariation($variation);
                $pricingArray[] = $pricing;
            }
            $variation->setPricing($pricingArray);
            $variations[] = $variation;
        }
        $draft->setVariations($variations);
        $product->setDraft($draft);
        $product->setId(1);
        $status = new Status();
        $product->setStatus($status);
        return $product;
    }
}