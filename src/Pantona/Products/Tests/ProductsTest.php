<?php namespace Pantona\Products\Tests;

use Pantona\Products\Model\Product;

class Products extends AbstractProductTest
{
    public function testGetSingleProductById()
    {
        $repository = $this->getMockBuilder('Pantona\Products\Entity\Repository\ProductRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $productEntity = $this->getDummyProduct();

        $repository->expects($this->once())
            ->method('getSingleProduct')
            ->with('1')
            ->willReturn($productEntity);

        $model = new Product($productEntity);
        $products = new \Pantona\Products\Products($repository);
        $this->assertEquals($model, $products->getSingleProductById(1));
    }

    public function testNotFoundGetSingleProductById()
    {
        $repository = $this->getMockBuilder('Pantona\Products\Entity\Repository\ProductRepository')
            ->disableOriginalConstructor()
            ->getMock();


        $repository->expects($this->once())
            ->method('getSingleProduct')
            ->with('1')
            ->willReturn(false);


        $this->setExpectedException('Pantona\Products\Exception\ProductNotExists');
        $products = new \Pantona\Products\Products($repository);
        $products->getSingleProductById(1);
    }
}