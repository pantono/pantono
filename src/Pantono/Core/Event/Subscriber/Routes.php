<?php namespace Pantono\Core\Event\Subscriber;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pantono\Core\Container\Application;
use Silex\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Pantono\Core\Exception\Bootstrap\Routes as RoutesException;
use Pantono\Core\Model\Route;

class Routes implements EventSubscriberInterface
{
    /**
     * @var Application
     */
    private $application;
    private $controllers;

    public static function getSubscribedEvents()
    {
        return [
            'pantono.application.start' => [
                ['loadRoutes', 100]
            ]
        ];
    }

    public function loadRoutes(General $event)
    {
        $app = $event->getApplication();
        $this->application = $app;
        $routes = [];
        foreach ($app->getBootstrap()->getModules() as $module) {
            $routes = array_merge_recursive($routes, $module->getRoutes());
        }
        $this->application['defined_routes'] = $routes;
        foreach ($routes as $name => $route) {
            $controllerId = $this->createController($route);
            if ($route['route']) {
                $this->loadRoute($controllerId, $name, $route);
            }
        }
    }

    private function createController($route)
    {
        if (!class_exists($route['controller'])) {
            throw new RoutesException('Controller ' . $route['controller'] . ' for route ' . $route['route'] . ' does not exist');
        }

        if (!method_exists($route['controller'], $route['action'])) {
            throw new RoutesException('Action ' . $route['action'] . ' does not exist within controller ' . $route['controller']);
        }
        $controllerId = str_replace('\\', '.', $route['controller']);
        if (!isset($this->controllers[$controllerId])) {
            $app = $this->application;
            $app[$controllerId] = $app->share(function() use ($app, $route) {
                $controller = $route['controller'];
                return new $controller($app, $app->getEventDispatcher(), $route['controller'], $route['action']);
            });
        }
        return $controllerId;
    }

    private function loadRoute($controllerId, $name, array $route)
    {
        $app = $this->application;
        $routeModel = $this->getRouteModel($route);
        $routeObject = $app->match($route['route'], $controllerId . ':' . $route['action'])
            ->before(function(Request $request, Application $app) use ($route, $routeModel) {
                $request->attributes->add(['pantono_route' => $routeModel]);
                if ($route['admin']) {
                    if (!$app->getPantonoService('AdminAuthentication')->isCurrentUserAuthenticated()) {
                        return new RedirectResponse('/admin/login');
                    }
                }
            })
            ->bind($name);
        $this->addRouteDefaults($routeObject, $route);
    }

    private function getRouteModel($route)
    {
        $routeModel = new Route();
        $routeModel->setController($route['controller']);
        $routeModel->setAction($route['action']);
        $routeModel->setPath($route['route']);
        $routeModel->setRequiresAdminAuth(isset($route['admin']) ? $route['admin'] : false);
        return $routeModel;
    }

    private function addRouteDefaults(Controller $routeObject, $route)
    {
        if (isset($route['defaults'])) {
            foreach ($route['defaults'] as $name => $value) {
                $routeObject->value($name, $value);
            }
        }
    }

    /**
     * @return Application
     */
    private function getApplication()
    {
        return $this->application;
    }
}
