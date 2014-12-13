<?php

namespace Csburton\SilEcom\Core\Event\Events;

use Csburton\SilEcom\Core\Container\Application;
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