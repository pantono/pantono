<?php namespace Pantono\Locale;

use Pantono\Core\Event\Dispatcher;
use Pantono\Locale\Entity\Repository\CurrencyRepository;
use \Pantono\Locale\Entity\Currency as CurrencyEntity;
use Pantono\Locale\Exception\CurrencyNotFound;
use Pantono\Locale\Exception\NoCurrenciesAvailable;
use Symfony\Component\HttpFoundation\Session\Session;

class Currency
{
    private $repository;
    private $dispatcher;
    private $activeCurrencies = [];
    private $session;
    private $currentCurrency;

    public function __construct(CurrencyRepository $repository, Dispatcher $dispatcher, Session $session)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
        $this->session = $session;
    }

    /**
     * @return \Pantono\Locale\Entity\Currency
     * @throws NoCurrenciesAvailable
     */
    public function getCurrentCurrency()
    {
        if (!$this->currentCurrency) {
            $currencies = $this->getActiveCurrencies();
            $sessionCurrency = $this->session->get('currency');
            if ($sessionCurrency) {
                $this->currentCurrency = $sessionCurrency;
                return $this->currentCurrency;
            }
            if (empty($currencies)) {
                throw new NoCurrenciesAvailable('No Currency available, Add a currency in main config file');
            }
            $this->currentCurrency = $currencies[0];
        }
        return $this->currentCurrency;
    }

    public function setCurrentCurrency($code)
    {
        $found = false;
        foreach ($this->getActiveCurrencies() as $currency) {
            if ($currency->getCode() == $code) {
                $found = $currency;
            }
        }
        if ($found === false) {
            throw new CurrencyNotFound('Currency ' . $code . ' is not in active currency list, add by using Currency::addaddActiveCurrency($code)');
        }
        $this->currentCurrency = $found;
        $this->session->set('currency', $this->currentCurrency);
        return $this->currentCurrency;
    }

    /**
     * Gets full list of currencies
     *
     * @param bool $hideDisabled
     * @return CurrencyEntity
     */
    public function getCurrencyList($hideDisabled = false)
    {
        $list = $this->repository->getCurrencyList($hideDisabled);
        return $list;
    }

    /**
     * Finds single currency by its currency code
     *
     * @param $code
     * @return null|CurrencyEntity
     */
    public function findCurrencyByCode($code)
    {
        return $this->repository->findCurrencyByCode($code);
    }

    /**
     * Updates an exchange for a currency
     *
     * @param $code
     * @param $rate
     * @throws CurrencyNotFound
     */
    public function updateCurrencyExchangeRateByCode($code, $rate)
    {
        $currency = $this->findCurrencyByCode($code);
        if ($currency === null) {
            throw new CurrencyNotFound('Currency ' . $code . ' cannot be found');
        }
        $currency->setExchangeRate($rate);
        $this->saveCurrency($currency);
    }

    /**
     * Saves currency object
     *
     * @param CurrencyEntity $currency
     */
    public function saveCurrency(CurrencyEntity $currency)
    {
        $this->dispatcher->dispatchCurrencyEvent(\Pantono\Core\Event\Events\Currency::PRE_SAVE, $currency);
        $this->repository->save($currency);
        $this->repository->flush();
        $this->dispatcher->dispatchCurrencyEvent(\Pantono\Core\Event\Events\Currency::POST_SAVE, $currency);
    }

    /**
     * @return mixed
     */
    public function getActiveCurrencies()
    {
        foreach ($this->activeCurrencies as $index => $currency) {
            if (!is_object($currency)) {
                $this->activeCurrencies[$index] = $this->findCurrencyByCode($currency);
            }
        }
        return $this->activeCurrencies;
    }

    public function addActiveCurrency($code)
    {
        if (!in_array($code, $this->getActiveCurrencies())) {
            $this->activeCurrencies[] = $code;
        }
    }
}
