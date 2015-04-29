<?php

namespace Pantono\Categories\Controller;

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
                if ($this->getCategoryService()->addCategory($form->getData())) {

                }
            }
        }
        return $this->renderTemplate('admin/categories/add.twig', ['form' => $form->createView()]);
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