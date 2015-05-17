<?php namespace Pantono\Acl\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WyriHaximus\SliFly\FlysystemServiceProvider;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantono.bootstrap.start' => [
                ['onBootstrap', 50]
            ]
        ];
    }

    public function onBootstrap(General $event)
    {
        $app = $event->getApplication();
        $app->getPantonoService('Acl')->loadPrivileges();
    }
}
