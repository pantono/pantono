<?php namespace Pantono\Locale\Helper;

use \Pantono\Locale\Currency;

class CurrencyHelper
{
    private $currency;
    private $twig;

    public function __construct(Currency $currency, \Twig_Environment $twig)
    {
        $this->currency = $currency;
        $this->twig = $twig;
    }

    public function renderCurrency($amount)
    {
        $symbol = $this->currency->getCurrentCurrency()->getSymbol();
        return $this->twig->render('helper/currency/single-currency.twig', ['amount' => $amount, 'symbol' => $symbol]);
    }

    public function renderCurrencyToFrom($to, $from)
    {
        $symbol = $this->currency->getCurrentCurrency()->getSymbol();
        return $this->twig->render('helper/currency/single-currency.twig', ['to' => $to, 'from' => $from, 'symbol' => $symbol]);
    }

}
