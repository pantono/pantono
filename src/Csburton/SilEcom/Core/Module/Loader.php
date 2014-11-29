<?php

namespace Csburton\SilEcom\Core\Module;

use Csburton\SilEcom\Core\Container\Application;

class Loader
{
    private $application;
    private $modules = [];
    private $entity_mappings = [];
    private $routes = [];

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
        $config = [];
        foreach ($this->modules as $module) {
            if ($module->getConfig()) {
                var_dump($module->getConfig());
                exit;
            }
        }
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
        $this->application['routes'] = $routes;
        foreach ($routes as $name => $route) {
            if ($route['admin'] === true) {
                $controller = 'Csburton\\SilEcom\\Core\\Model\\Controller\\Admin';
            } else {
                $controller = 'Csburton\\SilEcom\\Core\\Model\\Controller\\Frontend';
            }
            $this->application->match($route['route'], $controller.'::handleRequest')->bind($name);
        }
    }
}