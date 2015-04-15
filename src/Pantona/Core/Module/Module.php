<?php

namespace Pantona\Core\Module;

use Symfony\Component\Yaml\Parser;

class Module
{
    private $namespace;
    private $config;
    private $directory;
    private $routes;
    private $entityMappings;

    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function load()
    {
        $this->directory = APPLICATION_BASE . '/src/' . str_replace('\\', '/', $this->namespace);
        $this->loadConfig();
        $this->loadRoutes();
    }

    private function loadConfig()
    {
        if (file_exists($this->directory . '/config.yml')) {
            $parser = new Parser();
            $this->config = $parser->parse(file_get_contents($this->directory . '/config.yml'));
        }
    }

    private function loadRoutes()
    {
        if (file_exists($this->directory . '/routes.yml')) {
            $parser = new Parser();
            $this->routes = $parser->parse(file_get_contents($this->directory . '/routes.yml'));
        }
    }

    public function getEntityMapping()
    {
        if (file_exists($this->directory.'/Entity')) {
            return [
                'type' => 'annotation',
                'namespace' => $this->namespace.'\\Entity',
                'path' => $this->directory.'/Entity'
            ];
        }
        return [];
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
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
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return mixed
     */
    public function getEntityMappings()
    {
        return $this->entityMappings;
    }

    /**
     * @param mixed $entityMappings
     */
    public function setEntityMappings($entityMappings)
    {
        $this->entityMappings = $entityMappings;
    }
}