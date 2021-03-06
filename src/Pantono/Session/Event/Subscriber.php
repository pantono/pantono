<?php namespace Pantono\Session\Event;

use Pantono\Core\Event\Events\General;
use Silex\Provider\SessionServiceProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantono.bootstrap.start' => [
                ['onBootstrap', 80]
            ]
        ];
    }

    public function onBootstrap(General $event)
    {
        $app = $event->getApplication();
        $app->register(new SessionServiceProvider());
        $app->getServiceLocator()->registerAlias('session', 'session');
    }
}
