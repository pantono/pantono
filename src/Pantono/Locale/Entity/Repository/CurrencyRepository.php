<?php namespace Pantono\Locale\Entity\Repository;

use Pantono\Database\Repository\AbstractRepository;

class CurrencyRepository extends AbstractRepository
{
    /**
     * @param $code
     * @return null|\Pantono\Locale\Entity\Currency
     */
    public function findCurrencyByCode($code)
    {
        return $this->_em->getRepository('Pantono\Locale\Entity\Currency')->findOneBy(['code' => $code]);
    }

    /**
     * @param $hideDisabled
     * @return \Pantono\Locale\Entity\Currency
     */
    public function getCurrencyList($hideDisabled)
    {
        if ($hideDisabled === true) {
            return $this->_em->getRepository('Pantono\Locale\Entity\Currency')->findBy(['enabled' => true]);
        }
        return $this->_em->getRepository('Pantono\Locale\Entity\Currency')->findAll();
    }
}
