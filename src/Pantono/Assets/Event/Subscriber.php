<?php namespace Pantono\Assets\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WyriHaximus\SliFly\FlysystemServiceProvider;

/**
 * Event subscriber for bootstrapping asset related functionality
 *
 * Class Subscriber
 *
 * @package Pantono\Assets\Event
 * @author  Chris Burton <csburton@gmail.com>
 */
class Subscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'pantono.bootstrap.start' => [
                ['onBootstrap', 90]
            ]
        ];
    }

    /**
     * Bootstraps assets related functionality
     *
     * @param General $event General event object
     */
    public function onBootstrap(General $event)
    {
        $app = $event->getApplication();
        $app->register(new FlysystemServiceProvider(), [
            'flysystem.filesystems' => $app->getConfig()->getItem('filesystems', null, [])
        ]);
        $app['public_files'] = $app['flysystems']['assets'];
        $app['private_files'] = $app['flysystems']['private'];
        $app->getServiceLocator()->registerAlias('public_files', 'public_files');
        $app->getServiceLocator()->registerAlias('private_files', 'private_files');
    }
}
