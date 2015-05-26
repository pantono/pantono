<?php

namespace Pantono\Core\Controller;

use Pantono\Acl\Exception\Acl\Forbidden;
use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Event\Events\Template;
use Pantono\Database\Model\EntityMapping;
use Symfony\Component\Form\Form;

abstract class Controller
{
    protected $application;
    protected $request;
    protected $controller;
    protected $action;
    protected $eventDispatcher;

    public function __construct(Application $app, Dispatcher $dispatcher)
    {
        $this->application = $app;
        $this->eventDispatcher = $dispatcher;
    }

    public function checkAcl()
    {
        if (!$this->getApplication()->getPantonoService('Acl')->isAllowed($this->controller, $this->action)) {
            throw new Forbidden('You are not authorised to view this resource');
        }
    }

    protected function isAllowed($resource, $action)
    {
        return $this->getApplication()->getPantonoService('Acl')->isAllowed($resource, $action);
    }

    protected function getApplication()
    {
        return $this->application;
    }

    /**
     * @return \Pantono\Acl\Entity\AdminUser
     */
    protected function getCurrentUser()
    {
        return $this->getApplication()->getPantonoService('AdminAuthentication')->getCurrentUser();
    }

    protected function renderTemplate($templatePath, $variables = [])
    {
        $renderedContent = '';
        $this->eventDispatcher->dispatchTemplateEvent(Template::PRE_RENDER, $templatePath, $renderedContent, $this->controller, $this->action);
        $renderedContent = $this->getApplication()['twig']->render($templatePath, $variables);
        $this->eventDispatcher->dispatchTemplateEvent(Template::PRE_RENDER, $templatePath, $renderedContent, $this->controller, $this->action);
        return $renderedContent;
    }

    protected function renderJson($options, $status = 200)
    {
        $this->eventDispatcher->dispatchTemplateEvent(Template::JSON_PREPROCESS, $templatePath, $options, $this->controller, $this->action);
        $renderedContent = $this->getApplication()->json($options, $status);
        $this->eventDispatcher->dispatchTemplateEvent(Template::JSON_POSTPROCESS, $templatePath, $renderedContent, $this->controller, $this->action);
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

    protected function getFormErrors(Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }

        return $errors;
    }

    /**
     * @param $name
     * @return EntityMapping
     */
    protected function getFormMapping($name)
    {
        return $this->application->getPantonoService('EntityMapper')->getMappingByName($name);
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function getForm($name)
    {
        return $this->getApplication()->getForm($name);
    }

}
