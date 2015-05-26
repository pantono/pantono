<?php namespace Pantono\Products\Controller;

use Pantono\Core\Controller\Controller;
use Pantono\Products\Model\Filter\ProductListingFilter;
use Pantono\Products\Products;
use Pantono\Templates\Model\Table;

class Product extends Controller
{
    public function listAction()
    {
        $filter = new ProductListingFilter();
        $products = $this->getProductClass()->getProductList($filter);
        $table = new Table();
        $table->setHeaders([
            'Title',
            'Product Code',
            'Price',
            'Categories'
        ]);
        foreach ($products as $product) {
            $pricing = $product->getDraft()->getPriceMinMax();
            $pricingString = $pricing['min'].' - '.$pricing['max'];
            if ($pricing['min'] == $pricing['max']) {
                $pricingString = $pricing['min'];
            }
            $categories = [];
            foreach ($product->getDraft()->getCategories() as $category)
            {
                $categories[] = $category->getName();
            }
            $row = [
                $product->getDraft()->getTitle(),
                $product->getDraft()->getSku(),
                $pricingString,
                implode(', ', $categories)
            ];
            $table->addRow($row);
        }
        return $this->renderTemplate('admin/products/listing.twig', ['products' => $products, 'table' => $table]);
    }

    public function addAction()
    {
        return $this->renderTemplate('admin/products/add');
    }

    public function editAction()
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
