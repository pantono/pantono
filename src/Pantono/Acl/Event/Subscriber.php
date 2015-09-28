<?php namespace Pantono\Acl\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event subscriber for ACL related functionality
 *
 * Class Subscriber
 *
 * @package Pantono\Acl\Event
 * @author Chris Burton <csburton@gmail.com>
 */
class Subscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'pantono.application.start' => [
                ['loadAclPrivileges', 99]
            ]
        ];
    }

    /**
     * Loads the current set of ACL privileges into memory
     *
     * @param General $event
     */
    public function loadAclPrivileges(General $event)
    {
        $app = $event->getApplication();
        $app->getPantonoService('Acl')->loadPrivileges();
    }
}
