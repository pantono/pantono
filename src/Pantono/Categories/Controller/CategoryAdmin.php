<?php

namespace Pantono\Categories\Controller;

use Pantono\Categories\Model\Filter\CategoryListFilter;
use Pantono\Core\Controller\Controller;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pantono\Categories\Category as CategoryService;

/**
 * Controller class for category related management
 *
 * Class Category
 *
 * @package Pantono\Categories\Controller
 * @author  Chris Burton <csburton@gmail.com>
 */
class CategoryAdmin extends Controller
{
    /**
     * Controller action to view a list of categories with admin area
     *
     * @param Request $request Request object
     *
     * @return string|Response
     */
    public function listAction(Request $request)
    {
        $id = $request->get('id', null);
        $filter = new CategoryListFilter();
        $formWrapper = $this->getCategoryForm();
        $title = 'Add New Category';

        if ($id !== null) {
            $data = $this->getFlatCategoryData($id);
            $data['image'] = null;
            $formWrapper->getForm()->setData($data);
            $title = 'Edit Category ' . $id;
        }

        $result = $this->handleCategoryRequest($request, $formWrapper);
        if ($result !== null) {
            return $result;
        }
        $categories = $this->getCategoryService()->getCategoryList($filter);
        return $this->renderTemplate(
            'admin/categories/list.twig',
            [
                'categories' => $categories,
                'form' => $formWrapper->getForm()->createView(),
                'title' => $title
            ]
        );
    }

    /**
     * Returns an array of category data to be used within forms
     *
     * @param int $id Category ID
     *
     * @return array
     *
     * @throws \Pantono\Categories\Exception\CategoryNotFound
     */
    private function getFlatCategoryData($id)
    {
        $data = $this->getApplication()->getPantonoService('EntityDehydrator')->dehydrateEntity(
            $this->getFormMapping('category_add'),
            $this->getCategoryService()->getCategoryById($id)
        );
        return $data;
    }

    /**
     * Handles the category add request
     *
     * @param Request              $request     Request Object
     * @param FormBuilderInterface $formWrapper Category Form
     *
     * @return null|RedirectResponse
     */
    private function handleCategoryRequest(Request $request, FormBuilderInterface $formWrapper)
    {
        $form = $formWrapper->getForm();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $entity = $this->getApplication()
                    ->getPantonoService('EntityHydrator')
                    ->hydrateEntity($this->getFormMapping('category_add'), $data);

                if ($this->getCategoryService()->saveCategoryEntity($entity)) {
                    $this->flashMessenger($this->translate('Category has been updated'), 'success');
                    return new RedirectResponse('/admin/categories');
                }
            }
        }
        return null;
    }

    /**
     * Returns instance of the category form
     *
     * @return FormBuilderInterface
     */
    private function getCategoryForm()
    {
        return $this->getApplication()->getForm('category');
    }

    /**
     * Returns instance of the main category class
     *
     * @return CategoryService
     */
    private function getCategoryService()
    {
        return $this->getApplication()->getPantonoService('Category');
    }
}
