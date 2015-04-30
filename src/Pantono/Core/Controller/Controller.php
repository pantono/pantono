<?php

namespace Pantono\Core\Controller;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Event\Events\Template;
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
        $this->eventDispatcher->dispatchTemplateEvent(Template::PRE_RENDER, $templatePath, $renderedContent, $this->controller, $this->action);
        $renderedContent = $this->getApplication()['twig']->render($templatePath, $variables);
        $this->eventDispatcher->dispatchTemplateEvent(Template::PRE_RENDER, $templatePath, $renderedContent, $this->controller, $this->action);
        return $renderedContent;
    }

    protected function translate($string, $options = [])
    {
        return $this->application->getTranslator()->trans($string, $options);
    }

    protected function getService($name)
    {
        return $this->application->getPantonoService($name);
    }

    protected function flashMessenger($message, $type = 'info')
    {
        return $this->getService('FlashMessenger')->addMessage($message, $type);
    }
}