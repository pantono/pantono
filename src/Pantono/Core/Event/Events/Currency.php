<?php namespace Pantono\Core\Event\Events;

use \Pantono\Locale\Entity\Currency as CurrencyEntity;

class Currency extends General
{
    const PRE_SAVE = 'pantono.currency.pre-save';
    const POST_SAVE = 'pantono.currency.post-save';
    private $currency;

    /**
     * @return CurrencyEntity
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency(CurrencyEntity $currency)
    {
        $this->currency = $currency;
    }
}
