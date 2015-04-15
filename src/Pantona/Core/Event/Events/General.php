<?php

namespace Pantona\Core\Event\Events;

use Pantona\Core\Container\Application;
use Symfony\Component\EventDispatcher\Event;

class General extends Event
{
    private $application;

    public function __construct(Application $app)
    {
        $this->application = $app;
    }

    public function getApplication()
    {
        return $this->application;
    }
}