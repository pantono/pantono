<?php namespace Pantono\Locale\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Subscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantono.application.start' => [
                ['onAppStart', 80]
            ]
        ];
    }


    public function onAppStart(General $event)
    {
        $app = $event->getApplication();
        $currencies = $app->getConfig()->getItem('locale', 'currencies', []);
        $currencyClass = $app->getPantonoService('Currency');
        foreach ($currencies as $currency) {
            $currencyClass->addActiveCurrency($currency);
        }
    }
}
