<?php

namespace Pantono\Acl\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantono.bootstrap.finish' => [
                ['onBootstrap', 0]
            ]
        ];
    }

    public function onBootstrap(General $application)
    {
        $application->getApplication()->getConfig();
    }
}