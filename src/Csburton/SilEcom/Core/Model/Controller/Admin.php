<?php

namespace Csburton\SilEcom\Core\Model\Controller;

use Csburton\SilEcom\Core\Container\Application;
use Symfony\Component\HttpFoundation\Request;

class Admin
{
    protected $application;
    protected $request;
    protected $controller;
    protected $action;

    public function __construct(Application $app, $controller, $action)
    {
        $this->application = $app;
        $this->controller = $controller;
        $this->action = $action;
    }

    protected function getApplication()
    {
        return $this->application;
    }

    protected function getRequest()
    {
        return $this->request;
    }

    protected function renderTemplate($templatePath, $variables = [])
    {
        return $this->getApplication()['twig']->render($templatePath, $variables);
    }
}