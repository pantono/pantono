<?php

namespace Csburton\SilEcom\Acl\Event;

use Csburton\SilEcom\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'silecom.bootstrap.finish' => [
                ['onBootstrap', 0]
            ]
        ];
    }

    public function onBootstrap(General $application)
    {

    }
}