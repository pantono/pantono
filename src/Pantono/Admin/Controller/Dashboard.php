<?php namespace Pantono\Admin\Controller;

use Pantono\Core\Controller\AdminController;

class Dashboard extends AdminController
{
    public function indexAction()
    {
        return $this->renderTemplate('admin/dashboard/dashboard.twig');
    }
}