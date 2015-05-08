<?php namespace Pantono\Core;

use Pantono\Core\Container\Application;
use Pantono\Core\Exception\Bootstrap\Routes;
use Pantono\Core\Model\Config\Config;
use Pantono\Core\Model\Route;
use Pantono\Core\Module\Module;
use Silex\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class Bootstrap
{
    private $configFile;
    private $config;
    /**
     * @var Application
     */
    private $application;
    private $modules;
    private $controllers;
    private $serverVariables;

    public function __construct($configFile = '')
    {
        $this->configFile = $configFile;
    }

    /**
     * @return Application
     */
    public function boostrap($serverVariables = [])
    {
        $this->serverVariables = $serverVariables;
        $application = new Application();
        $application['debug'] = true;
        $this->application = $application;
        $this->application['bootstrap'] = $this;
        $this->initDefinitions();
        $this->initLocale();
        $this->loadModules();
        $this->loadRoutes();
        return $this->application;
    }

    private function initDefinitions()
    {
        define('BOOTSTRAP_START', microtime(true));
        define('APPLICATION_BASE', realpath(__DIR__ . '/../../../'));
        define('APPLICATION_PUBLIC', realpath(APPLICATION_BASE . '/public'));
    }

    public function addModule($namespace)
    {
        $module = new Module($this->application, $namespace);
        $module->load();
        if ($module->getConfigFile() !== null) {
            $this->getConfig()->addFile($module->getConfigFile());
        }
        $this->modules[$namespace] = $module;
    }

    public function addModules($modules = [])
    {
        foreach ($modules as $namespace) {
            $this->addModule($namespace);
        }
    }

    private function loadModules()
    {
        $this->addModules($this->getConfig()->getItem('modules', null, []));
    }

    protected function initLocale()
    {
        if (php_sapi_name() == 'cli') {
            $this->application['locale'] = 'en';
            return;
        }
        $locale = locale_accept_from_http($this->serverVariables['HTTP_ACCEPT_LANGUAGE']);
        if (false !== strpos($locale, '_')) {
            $localeArray = explode('_', $locale);
            $locale = $localeArray[0];
        }
        $this->application['locale'] = $locale;

    }

    public function getConfig()
    {
        if (empty($this->config)) {
            $this->config = new Config();
            $this->config->addFile($this->configFile);
            $this->application['config'] = $this->config;
        }
        return $this->config;
    }

    /**
     * @return Module[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    public function loadRoutes()
    {
        $routes = [];
        foreach ($this->getModules() as $module) {
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
            throw new Routes('Controller ' . $route['controller'] . ' for route ' . $route['route'] . ' does not exist');
        }

        if (!method_exists($route['controller'], $route['action'])) {
            throw new Routes('Action ' . $route['action'] . ' does not exist within controller ' . $route['controller']);
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

    public function getCommandLineRunner()
    {
        $application = new \Symfony\Component\Console\Application();
        foreach ($this->getModules() as $module) {
            foreach ($module->getConfig()->getItem('commands', null, []) as $command) {
                $command = new $command;
                $command->setContainer($this->application);
                $application->add($command);
            }
        }
        return $application;
    }
}