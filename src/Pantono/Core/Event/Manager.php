<?php

namespace Pantono\Core\Event;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Manager
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function addSubscriber($class)
    {
        $subscriber = new $class;
        $this->dispatcher->addSubscriber($subscriber);
    }
}