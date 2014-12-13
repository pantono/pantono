<?php

namespace Csburton\SilEcom\Core\Event;

use Csburton\SilEcom\Core\Container\Application;
use Csburton\SilEcom\Core\Event\Events\General;
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