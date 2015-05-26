<?php namespace Pantono\Templates\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use \Pantono\Core\Event\Events\Table as TableEvent;

class Table implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            TableEvent::PRE_RENDER => [
                ['tableAddClass', 90]
            ]
        ];
    }

    public function tableAddCLass(TableEvent $event)
    {
        $event->getTable()->appendToAttribute('class', 'table table-bordered table-striped');
    }
}
