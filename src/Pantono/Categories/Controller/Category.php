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
        $form = $this->getCategoryForm($request);
        return $this->renderTemplate('admin/categories/add.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @return \Pantono\Categories\Form\Category
     */
    private function getCategoryForm(Request $request)
    {
        return $this->getApplication()->getForm('category')->getForm();
    }
}