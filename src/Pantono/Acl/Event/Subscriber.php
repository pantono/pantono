<?php namespace Pantono\Acl\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WyriHaximus\SliFly\FlysystemServiceProvider;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantono.application.start' => [
                ['loadAclPrivileges', 100]
            ]
        ];
    }

    public function loadAclPrivileges(General $event)
    {
        $app = $event->getApplication();
        $app->getPantonoService('Acl')->loadPrivileges();
    }
}
