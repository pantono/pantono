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
        $postData = $request->request->all();
        return $this->renderTemplate('admin/categories/add.twig', ['form' => $form->createView(), 'postData' => $postData]);
    }

    /**
     * @return \Pantono\Categories\Form\Category
     */
    private function getCategoryForm()
    {
        return $this->getApplication()->getForm('category')->getForm();
    }
}