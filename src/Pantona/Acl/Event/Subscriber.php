<?php

namespace Pantona\Acl\Event;

use Pantona\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantona.bootstrap.finish' => [
                ['onBootstrap', 0]
            ]
        ];
    }

    public function onBootstrap(General $application)
    {
        $application->getApplication()->getConfig();
    }
}