<?php namespace Pantono\Products\Tests;

use Pantono\Products\Model\Product;

class Products extends AbstractProductTest
{
    public function testGetSingleProductById()
    {
        $repository = $this->getMockBuilder('Pantono\Products\Entity\Repository\ProductRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $eventManager = $this->getMockBuilder('Pantono\Core\Event\Manager')
            ->disableOriginalConstructor()
            ->getMock();
        $productEntity = $this->getDummyProduct();

        $repository->expects($this->once())
            ->method('getSingleProduct')
            ->with('1')
            ->willReturn($productEntity);

        $model = new Product($productEntity);
        $products = new \Pantono\Products\Products($repository, $eventManager);
        $this->assertEquals($model, $products->getSingleProductById(1));
    }

    public function testNotFoundGetSingleProductById()
    {
        $repository = $this->getMockBuilder('Pantono\Products\Entity\Repository\ProductRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $eventManager = $this->getMockBuilder('Pantono\Core\Event\Manager')
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method('getSingleProduct')
            ->with('1')
            ->willReturn(false);


        $this->setExpectedException('Pantono\Products\Exception\ProductNotExists');
        $products = new \Pantono\Products\Products($repository, $eventManager);
        $products->getSingleProductById(1);
    }
}
