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
            $pricingCell->setCurrency(true);
            $categoriesCell = new Cell($product->getDraft()->getCategoryString());
            $row = new Row();
            $row->addCell(new Cell($product->getDraft()->getTitle()));
            $row->addCell(new Cell($product->getDraft()->getSku()));
            $row->addCell($pricingCell);
            $row->addCell($categoriesCell);
            $editAction = new Action();
            $editAction->setClasses('btn btn-default fa fa-edit');
            $editAction->setUrl('/admin/products/edit/' . $product->getId());
            $row->addAction($editAction);
            $deleteAction = new Action();
            $deleteAction->setUrl('/admin/products/delete/' . $product->getId());
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
