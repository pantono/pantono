<?php namespace Pantono\Form\Event;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Events\General;
use Pantono\Form\Element\Extensions\ImageUpload;
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
        $this->registerCustomTypes($app);
    }

    public function registerCustomTypes(Application $app)
    {
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $customTypes = $app->getConfig()->getItem('custom_form_types', null, []);
            foreach ($customTypes as $type) {
                if (class_exists($type)) {
                    $types[] = new $type;
                }
            }
            return $types;
        }));
    }
}
