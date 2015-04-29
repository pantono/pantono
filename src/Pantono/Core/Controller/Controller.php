<?php

namespace Pantono\Core\Controller;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    protected $application;
    protected $request;
    protected $controller;
    protected $action;
    protected $eventDispatcher;

    public function __construct(Application $app, Dispatcher $dispatcher, $controller, $action)
    {
        $this->application = $app;
        $this->controller = $controller;
        $this->action = $action;
        $this->eventDispatcher = $dispatcher;
    }

    protected function getApplication()
    {
        return $this->application;
    }

    protected function renderTemplate($templatePath, $variables = [])
    {
        $renderedContent = '';
        $this->eventDispatcher->dispatchTemplateEvent('pantono.template.prerender', $templatePath, $renderedContent, $this->controller, $this->action);
        $renderedContent = $this->getApplication()['twig']->render($templatePath, $variables);
        $this->eventDispatcher->dispatchTemplateEvent('pantono.template.postrender', $templatePath, $renderedContent, $this->controller, $this->action);
        return $renderedContent;
    }

    protected function getService($name)
    {
        return $this->application->getPantonoService($name);
    }

    protected function flashMessenger($message, $type = 'info')
    {
        $this->getService('session')->set('FlashMessenger')->addMessage($message, $type);
    }
}