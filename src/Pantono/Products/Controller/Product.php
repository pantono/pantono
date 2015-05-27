<?php namespace Pantono\Products\Controller;

use Pantono\Core\Controller\Controller;
use Pantono\Products\Model\Filter\ProductListingFilter;
use Pantono\Products\Products;
use Pantono\Templates\Model\Table\Action;
use Pantono\Templates\Model\Table\Cell;
use Pantono\Templates\Model\Table\Row;
use Pantono\Templates\Model\Table\Table;

class Product extends Controller
{
    public function listAction()
    {
        $filter = new ProductListingFilter();
        return $this->renderTemplate('admin/products/listing.twig', ['table' => $this->getProductListingTable($filter)]);
    }

    public function addAction()
    {
        return $this->renderTemplate('admin/products/add');
    }

    public function editAction()
    {
        return $this->renderTemplate('admin/products/edit');
    }

    private function getProductListingTable(ProductListingFilter $filter)
    {

        $products = $this->getProductClass()->getProductList($filter);
        $table = new Table();
        $table->setHeaders(['Title', 'Product Code', 'Price', 'Categories']);
        foreach ($products as $product) {
            $pricingCell = new Cell($product->getDraft()->getPriceMinMax());
            $pricingCell->setFormatter(function ($pricing) {
                if ($pricing['min'] == $pricing['max']) {
                    return $pricing['min'];
                }
                return $pricing['min'] . ' - ' . $pricing['max'];
            });
            $categoriesCell = new Cell($product->getDraft()->getCategories());
            $categoriesCell->setFormatter(function ($categories) {
                $cats = [];
                foreach ($categories as $category) {
                    $cats[] = $category->getName();
                }
                return implode(', ', $cats);
            });
            $row = new Row();
            $row->addCell(new Cell($product->getDraft()->getTitle()));
            $row->addCell(new Cell($product->getDraft()->getSku()));
            $row->addCell($pricingCell);
            $row->addCell($categoriesCell);
            $action = new Action();
            $action->setClasses('btn btn-default fa fa-edit');
            $action->setUrl('/admin/products/edit/' . $product->getId());
            $row->addAction($action);
            $table->addRow($row);
        }
        return $table;
    }

    /**
     * @return Products
     */
    private function getProductClass()
    {
        return $this->getService('products');
    }
}
