<?php namespace Pantono\Locale\Event;

use Pantono\Core\Event\Events\General;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CurrencyHelper implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'pantono.application.start' => [
                ['onAppStart', 90]
            ]
        ];
    }

    public function onAppStart(General $event)
    {
        $app = $event->getApplication();
        $app['twig']->addFunction(new \Twig_SimpleFunction('currency', function ($to, $from = false) use ($app) {
            if ($from === false) {
                return $app->getPantonoService('CurrencyHelper')->renderCurrency($to);
            }
            return $app->getPantonoService('CurrencyHelper')->renderCurrencyToFrom($to, $from);
        }));
    }
}
