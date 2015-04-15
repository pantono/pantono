<?php

namespace Pantona\Core\Event;

use Pantona\Core\Container\Application;
use Pantona\Core\Event\Events\General;
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