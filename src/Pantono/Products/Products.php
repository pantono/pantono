<?php namespace Pantono\Products;

use Pantono\Core\Event\Manager;
use Pantono\Products\Entity\Repository\ProductRepository;
use Pantono\Products\Model\Filter\ProductListingFilter;
use Pantono\Products\Model\Product;

class Products
{
    private $repository;
    private $eventManager;

    public function __construct(ProductRepository $repository, Manager $eventManager)
    {
        $this->repository = $repository;
        $this->eventManager = $eventManager;
    }


    /**
     * Get's a single product by its unique identifier
     *
     * @param $id
     * @return Product
     * @throws Exception\ProductNotExists
     */
    public function getSingleProductById($id)
    {
        $productEntity = $this->repository->getSingleProduct($id);
        if (!$productEntity) {
            throw new Exception\ProductNotExists('Product ' . $id . ' does not exist');
        }
        $productModel = new Product($productEntity);
        return $productModel;
    }

    public function getProductList(ProductListingFilter $filter)
    {
        $products = $this->repository->getProducts($filter);
        return $products;
    }

    /**
     * @return Manager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
}
