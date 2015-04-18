<?php

namespace Pantono\Core\Provider;

use Pantono\Core\Container\Application;

abstract class Service
{
    private $application;

    abstract public function getService();

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    protected function getApplication()
    {
        return $this->application;
    }
}