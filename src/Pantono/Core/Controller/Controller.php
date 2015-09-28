<?php

namespace Pantono\Core\Controller;

use Pantono\Acl\Exception\Acl\Forbidden;
use Pantono\Core\Container\Application;
use Pantono\Core\Event\Dispatcher;
use Pantono\Core\Event\Events\Template;
use Pantono\Core\Model\Route;
use Pantono\Database\Model\EntityMapping;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Abstract controller class. All controllers should extend this class
 *
 * @package Pantono\Core\Controller
 * @author  Chris Burton <csburton@gmail.com>
 */
abstract class Controller
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var Dispatcher
     */
    protected $eventDispatcher;

    /**
     * @var Route
     */
    protected $routeModel;

    /**
     * @param Application $app
     * @param Dispatcher  $dispatcher
     */
    public function __construct(Application $app, Dispatcher $dispatcher)
    {
        $this->application = $app;
        $this->eventDispatcher = $dispatcher;
    }

    /**
     * Checks current action against ACL registry
     *
     * @return bool|RedirectResponse
     *
     * @throws Forbidden
     */
    public function checkAcl()
    {
        if ($this->getRouteModel()->isSkipAcl()) {
            return true;
        }
        $currentUserId = $this->application['session']->get('admin_user_id');
        if ($currentUserId === null) {
            return new RedirectResponse('/admin/login');
        }
        if (!$this->getApplication()->getPantonoService('Acl')->isAllowed($this->controller, $this->action)) {
            throw new Forbidden('You are not authorised to view this resource');
        }
    }

    /**
     * @param string $resource Resource to check
     * @param string $action   Action to check
     *
     * @return bool
     */
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


    protected function getCurrencySymbol()
    {
        return $this->getService('Currency')->getCurrentCurrency()->getSymbol();
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

    protected function getFormErrors(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
                continue;
            }
            $errors[] = $error->getMessage();
        }
        $errors = array_merge($errors, $this->getFormErrorsFromFields($form));
        return $errors;
    }

    public function getFormErrorsFromFields(FormInterface $form)
    {
        $errors = [];
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getFormErrors($child);
            }
        }
        return $errors;
    }

    /**
     * @param $name
     *
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
     * @return FormBuilderInterface
     */
    public function getForm($name)
    {

        return $this->getApplication()->getForm($name);
    }

    /**
     * @return Route
     */
    public function getRouteModel()
    {
        return $this->routeModel;
    }

    /**
     * @param Route $routeModel
     */
    public function setRouteModel(Route $routeModel)
    {
        $this->routeModel = $routeModel;
    }
}
