<?php

namespace Pantono\Categories\Controller;

use Pantono\Categories\Model\Filter\CategoryListFilter;
use Pantono\Core\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class Category extends Controller
{
    public function addAction(Request $request)
    {
        $form = $this->getCategoryForm();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                if ($this->getCategoryService()->saveCategory($form->getData())) {
                    $this->flashMessenger($this->translate('Category has been added'), 'success');
                    return new RedirectResponse('/admin/categories');
                }
            }
        }
        return $this->renderTemplate('admin/categories/add.twig', ['form' => $form->createView()]);
    }

    public function listAction(Request $request)
    {
        $id = $request->get('id', null);
        $filter = new CategoryListFilter();
        $form = $this->getCategoryForm();
        $actionText = 'added';
        if ($id !== null) {
            $category = $this->getCategoryService()->getCategoryById($id, true);
            $category['image'] = null;
            $form->setData($category);
            $actionText = 'updated';
        }
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                if ($this->getCategoryService()->saveCategory($form->getData())) {
                    $this->flashMessenger($this->translate('Category has been ' . $actionText), 'success');
                    return new RedirectResponse('/admin/categories');
                }
            }
        }
        $categories = $this->getCategoryService()->getCategoryList($filter);
        return $this->renderTemplate('admin/categories/list.twig', ['categories' => $categories, 'form' => $form->createView()]);
    }


    /**
     * @return \Symfony\Component\Form\Form
     */
    private function getCategoryForm()
    {
        return $this->getApplication()->getForm('category')->getForm();
    }

    /**
     * @return \Pantono\Categories\Category
     */
    private function getCategoryService()
    {
        return $this->getApplication()->getPantonoService('Category');
    }
}