<?php namespace Pantono\Products\Controller;

use Pantono\Categories\Category;
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
        $formWrapper = $this->getProductForm();
        $categories = $this->getCategoriesClass()->getCategoryListTree();
        return $this->renderTemplate(
            'admin/products/add.twig',
            ['form' => $formWrapper->getForm()->createView(), 'categories' => $categories]
        );
    }

    public function editAction()
    {
        return $this->renderTemplate('admin/products/edit.twig');
    }

    private function getProductListingTable(ProductListingFilter $filter)
    {
        $products = $this->getProductClass()->getProductList($filter);
        $table = new Table();
        $table->setHeaders(['Title', 'Product Code', 'Price', 'Categories']);
        foreach ($products as $product) {
            $row = new Row();
            $row->addCell(new Cell($product->getDraft()->getTitle()));
            $row->addCell(new Cell($product->getDraft()->getSku()));
            $row->addCell((new Cell($product->getDraft()->getPriceMinMax()))->setCurrency(true));
            $row->addCell(new Cell($product->getDraft()->getCategoryString()));
            $editAction = (new Action())->setClasses('btn btn-default fa fa-edit')->setUrl('/admin/products/edit/' . $product->getId());
            $row->addAction($editAction);
            $deleteAction = (new Action())->setUrl('/admin/products/delete/' . $product->getId());
            $row->addAction($deleteAction);
            $table->addRow($row);
        }
        return $table;
    }

    /**
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    private function getProductForm()
    {
        return $this->getApplication()->getForm('product');
    }

    /**
     * @return Products
     */
    private function getProductClass()
    {
        return $this->getService('products');
    }

    /**
     * @return Category
     */
    private function getCategoriesClass()
    {
        return $this->getService('Category');
    }
}
