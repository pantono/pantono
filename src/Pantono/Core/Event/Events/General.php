<?php

namespace Pantono\Core\Event\Events;

use Pantono\Core\Container\Application;
use Symfony\Component\EventDispatcher\Event;

class General extends Event
{
    private $application;

    public function __construct(Application $app)
    {
        $this->application = $app;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }
}