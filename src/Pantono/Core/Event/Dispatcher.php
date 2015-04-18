<?php

namespace Pantono\Core\Event;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Dispatcher
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function dispatchGeneralEvent($event)
    {
        $this->application['dispatcher']->dispatch($event, new General($this->application));
    }
}