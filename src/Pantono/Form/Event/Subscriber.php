<?php namespace Pantono\Form\Event;

use Pantono\Core\Event\Events\General;
use Pantono\Form\Extensions;
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
        $app['form.extensions'] = $app->share($app->extend('form.extensions', function ($extensions) use ($app) {
            $extensions[] = new Extensions($app->getConfig(), $app->getEventDispatcher(), $app);
            return $extensions;
        }));
        $app['form_element_handlers'] = $app->getConfig()->getItem('form_elements', null, []);
    }
}