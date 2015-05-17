<?php namespace Pantono\Products\Controller;

use Pantono\Core\Controller\Controller;
use Pantono\Products\Model\Filter\ProductListingFilter;
use Pantono\Products\Products;
use Symfony\Component\HttpFoundation\Request;

class Product extends Controller
{
    public function listAction(Request $request)
    {
        $filter = new ProductListingFilter();
        $products = $this->getProductClass()->getProductList($filter);
        return $this->renderTemplate('admin/products/listing.twig', ['products' => $products]);
    }

    public function addAction(Request $request)
    {
        return $this->renderTemplate('admin/products/add');
    }

    public function editAction(Request $request)
    {
        return $this->renderTemplate('admin/products/edit');
    }

    /**
     * @return Products
     */
    private function getProductClass()
    {
        return $this->getService('products');
    }
}
