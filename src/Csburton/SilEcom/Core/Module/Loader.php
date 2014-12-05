<?php

namespace Csburton\SilEcom\Core\Module;

use Csburton\SilEcom\Core\Container\Application;
use Csburton\SilEcom\Core\Exception\Bootstrap\Routes;

class Loader
{
    private $application;
    private $modules = [];
    private $routes = [];
    private $controllers = [];
    private $config = [];

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getModule($namespace)
    {
        if (!isset($this->modules[$namespace])) {
            throw new \Exception('Trying to call module which isn\'t loaded (' . $namespace . ')');
        }
        return $this->modules[$namespace];
    }

    public function loadModule($namespace)
    {
        $module = new Module($namespace);
        $module->load();
        $this->modules[$namespace] = $module;
    }

    public function getEntityMappings()
    {
        $mappings = [];
        foreach ($this->modules as $module) {
            if ($module->getEntityMapping()) {
                $mappings[] = $module->getEntityMapping();
            }
        }
        return $mappings;
    }

    public function getConfig()
    {
        if (!$this->config) {
            $config = [];
            foreach ($this->modules as $module) {
                if ($module->getConfig()) {
                    $config += $module->getConfig();
                }
            }
            $this->config = $config;
        }
        return $this->config;
    }

    public function getRoutes()
    {
        $routes = [];
        foreach ($this->modules as $module) {
            if ($module->getRoutes()) {
                $routes += $module->getRoutes();
            }
        }
        $this->routes = $routes;
        return $this->routes;
    }

    public function loadRoutes()
    {
        $routes = $this->getRoutes();
        $this->application['defined_routes'] = $routes;
        $app =& $this->application;
        foreach ($routes as $name => $route) {
            $controllerId = str_replace('\\', '.', $route['controller']);
            if (!class_exists($route['controller'])) {
                throw new Routes('Controller '.$route['controller'].' for route '.$routes['route'].' does not exist');
            }

            if (!method_exists($route['controller'], $route['action'])) {
                throw new Routes('Action '.$route['action'].' does not exist within controller '.$route['controller']);
            }

            if (!isset($this->controllers[$controllerId])) {
                $this->controllers[$controllerId] = true;
                $app[$controllerId] = $app->share(function() use ($app, $route) {
                    $controller = $route['controller'];
                    return new $controller($app, $route['controller'], $route['action']);
                });
            }
            if ($route['route']) {
                $app->match($route['route'], $controllerId.':'.$route['action']);//->bind($name);
                //@todo insert ACL here in ->before()
            }
        }
    }
}