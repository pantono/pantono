<?php namespace Pantono\Admin\Controller;

use Pantono\Core\Controller\Controller;

class Dashboard extends Controller
{
    public function indexAction()
    {
        return $this->renderTemplate('admin/dashboard/dashboard.twig');
    }
}