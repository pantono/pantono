<?php

namespace Pantono\Categories\Controller;

use Pantono\Categories\Model\Filter\CategoryListFilter;
use Pantono\Core\Controller\Controller;
use Pantono\Form\Hydrator;
use Symfony\Component\Form\FormBuilder;
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
        $formWrapper = $this->getCategoryForm();
        $form = $formWrapper->getForm();
        $title = 'Add New Category';
        if ($id !== null) {
            $category = $this->getCategoryService()->getCategoryById($id);
            $data = $this->getHydrator()->flattenEntity($category);
            $data['image'] = null;
            $form->setData($data);
            $title = 'Edit Category ' . $id;
        }
        $result = $this->handleCategoryRequest($request, $formWrapper);
        if ($result !== null) {
            return $result;
        }
        $categories = $this->getCategoryService()->getCategoryList($filter);
        return $this->renderTemplate('admin/categories/list.twig', ['categories' => $categories, 'form' => $form->createView(), 'title' => $title]);
    }

    private function handleCategoryRequest(Request $request, FormBuilder $formWrapper)
    {
        $form = $formWrapper->getForm();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entity = $this->getHydrator()->getHydratedEntity($formWrapper, $data);
                if ($this->getCategoryService()->saveCategoryEntity($entity)) {
                    $this->flashMessenger($this->translate('Category has been updated'), 'success');
                    return new RedirectResponse('/admin/categories');
                }
            }
        }
        return null;
    }

    /**
     * @return mixed|Hydrator
     */
    private function getHydrator()
    {
        return $this->getApplication()->getPantonoService('Hydrator');
    }


    /**
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    private function getCategoryForm()
    {
        return $this->getApplication()->getForm('category');
    }

    /**
     * @return \Pantono\Categories\Category
     */
    private function getCategoryService()
    {
        return $this->getApplication()->getPantonoService('Category');
    }
}