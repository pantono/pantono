<?php namespace Pantono\Assets\Event;

use Pantono\Core\Container\Application;
use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WyriHaximus\SliFly\FlysystemServiceProvider;

class Subscriber implements EventSubscriberInterface
{
    /**
     * @var Application
     */
    private $application;

    public static function getSubscribedEvents()
    {
        return [
            'pantono.bootstrap.start' => [
                ['onBootstrap', 100]
            ]
        ];
    }

    public function onBootstrap(General $event)
    {
        $this->application = $event->getApplication();

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