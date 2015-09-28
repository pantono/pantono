<?php

namespace Pantono\Admin\Controller;

use Pantono\Core\Controller\Controller;

/**
 * Provides controller actions for admin dashboard functionality
 *
 * Class Dashboard
 *
 * @package Pantono\Admin\Controller
 * @author  Chris Burton <csburton@gmail.com>
 */
class Dashboard extends Controller
{
    /**
     * Controller action for rendering main admin dashboard
     *
     * @return string
     */
    public function indexAction()
    {
        return $this->renderTemplate('admin/dashboard/dashboard.twig');
    }
}
