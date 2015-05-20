<?php namespace Pantono\Acl\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantono.application.start' => [
                ['loadAclPrivileges', 99]
            ]
        ];
    }

    public function loadAclPrivileges(General $event)
    {
        $app = $event->getApplication();
        $app->getPantonoService('Acl')->loadPrivileges();
    }
}