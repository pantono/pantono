<?php namespace Pantono\Core\Service;

use Pantono\Core\Container\Application;
use Pantono\Core\Exception\Service\NotFound;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class Locator
{
    private $application;
    private $services;
    private $aliases;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getService($name)
    {
        if ($service = $this->getLoadedService($name)) {
            return $service;
        }
        if (!$this->isServiceRegistered($name)) {
            throw new NotFound('Service ' . $name . ' is not registered');
        }
        $service = $this->services[$name];

        $params = [];
        foreach ($service['params'] as $param) {
            $params[] = $this->generateParameter($param);
        }
        $result = call_user_func_array(
            [new \ReflectionClass($service['class']), 'newInstance'],
            $params
        );
        $this->application['pantono.service.' . $name] = $result;
        return $this->application['pantono.service.' . $name];
    }

    public function registerService($name, $class, $params)
    {
        $this->services[$name] = [
            'class' => $class,
            'params' => $params
        ];
    }

    public function registerAlias($name, $alias)
    {
        $this->aliases[$name] = $alias;
    }

    private function generateParameter($param)
    {
        if (is_array($param)) {
            return $this->generateArrayParameter($param);
        }

        if (substr($param, 0, 1) === '@') {
            return $this->getService(substr($param, 1));
        }
        if (substr($param, 0, 1) === '~') {
            $class = substr($param, 1);
            return new $class;
        }
        return $param;
    }

    private function generateArrayParameter(array $param)
    {
        if ($param[0] === 'Repository') {
            return $this->application->getEntityManager()->getRepository($param[1]);
        }
        throw new ServiceNotFoundException('Service ' . $param[0] . ' not found');
    }

    public function isServiceRegistered($name)
    {
        $service = isset($this->services[$name]) ? $this->services[$name] : null;
        if ($service === null) {
            return false;
        }
        return true;
    }

    private function getLoadedService($name)
    {
        if (strtolower($name) === 'application') {
            return $this->application;
        }
        if (isset($this->application['pantono.service.' . $name])) {
            return $this->application['pantono.service.' . $name];
        }
        if (isset($this->aliases[$name])) {
            return $this->application[$this->aliases[$name]];
        }
    }
}