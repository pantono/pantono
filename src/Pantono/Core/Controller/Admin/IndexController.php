<?php

namespace Pantono\Core\Controller\Admin;

use Pantono\Core\Model\Controller\Admin;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Admin
{
    public function indexAction()
    {
        return $this->renderTemplate('admin/dashboard.twig');
    }

    public function homeAction()
    {
        return $this->renderTemplate('admin/dashboard/dashboard.twig');
    }
}