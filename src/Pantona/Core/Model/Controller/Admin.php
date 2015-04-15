<?php

namespace Pantona\Core\Model\Controller;

use Pantona\Core\Container\Application;
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

    public function __invoke()
    {

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

    protected function getService($name)
    {
        return $this->application->getPantonaService($name);
    }
}