<?php

namespace Pantono\Core\Module;

use Pantono\Acl\Model\Permission;
use Pantono\Core\Container\Application;
use Pantono\Core\Model\Config\Config;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Module
{
    private $namespace;
    private $config;
    private $directory;
    private $routes = [];
    private $application;
    private $eventListeners;
    private $permissions = [];

    public function __construct(Application $application, $namespace)
    {
        $this->namespace = $namespace;
        $this->application = $application;
    }

    public function load()
    {
        $this->directory = APPLICATION_BASE . '/src/' . str_replace('\\', '/', $this->namespace);
        $this->loadConfig();
        $this->loadRoutes();
        $this->loadServices();
        $this->loadEventListeners();
        $this->loadPermissions();
    }

    public function getConfigFile()
    {
        return file_exists($this->directory . '/config.yml') ? $this->directory . '/config.yml' : null;
    }

    private function loadConfig()
    {
        if (file_exists($this->directory . '/config.yml')) {
            $config = new Config();
            $config->addFile($this->directory . '/config.yml');
            $this->setConfig($config);
            return true;
        }
        $this->setConfig(new Config());
    }

    private function loadRoutes()
    {
        if (file_exists($this->directory . '/routes.yml')) {
            $parser = new Parser();
            $routesConfig = $parser->parse(file_get_contents($this->directory . '/routes.yml'));
            if (is_array($routesConfig)) {
                $this->routes = $routesConfig;
            }
        }
    }


    public function getEntityMapping()
    {
        if (file_exists($this->directory . '/Entity')) {
            return [
                'type' => 'annotation',
                'namespace' => $this->namespace . '\\Entity',
                'path' => $this->directory . '/Entity',
                'use_simple_annotation_reader' => false
            ];
        }
        return [];
    }

    private function loadEventListeners()
    {
        /**
         * @var $subscriber EventSubscriberInterface
         */
        foreach ($this->getConfig()->getItem('event_subscribers', null, []) as $subscriber) {
            $this->application->getEventManager()->addSubscriber($subscriber);
            $events = $subscriber::getSubscribedEvents();
            $this->eventListeners[] = $events;
        }
    }

    public function getEventListeners()
    {
        if (empty($this->eventListeners)) {
            $this->loadEventListeners();
        }
        return $this->eventListeners;
    }

    private function loadServices()
    {
        foreach ($this->getConfig()->getItem('services', null, []) as $name => $service) {
            $class = isset($service['class']) ? $service['class'] : null;
            $arguments = isset($service['arguments']) ? $service['arguments'] : null;
            $this->application->getServiceLocator()->registerService($name, $class, $arguments);
        }
    }

    private function loadPermissions()
    {
        $permissions = $this->getConfig()->getItem('permissions', null, []);
        foreach ($permissions as $resource => $permission) {
            foreach ($permission['actions'] as $action => $actionName) {
                $permissionModel = new Permission();
                $permissionModel->setResourceName($permission['name']);
                $permissionModel->setName($actionName);
                $permissionModel->setAction($action);
                $permissionModel->setResource($resource);
                $this->permissions[$resource . '::' . $action] = $permissionModel;
            }
        }
    }

    public function getCommandLineCommands()
    {
        return $this->getConfig()->getItem('commands');
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param mixed $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param mixed $routes
     */
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
