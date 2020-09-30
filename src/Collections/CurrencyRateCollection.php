<?php

namespace CentralBankRussian\ExchangeRate\Collections;

use CentralBankRussian\ExchangeRate\Models\CurrencyRate;
use Iterator;

/**
 * Class CurrencyRateCollection
 * @package Drandin\ExchangeRate\Collections
 */
class CurrencyRateCollection implements Iterator
{
    /**
     * @var array
     */
    private $currencyRates = [];

    /**
     * @param CurrencyRate $currencyRate
     */
    public function add(CurrencyRate $currencyRate)
    {
        $this->currencyRates[$currencyRate->getSymbolCode()] = $currencyRate;
    }

    /**
     * @return CurrencyRate|false
     */
    public function current()
    {
        return current($this->currencyRates);
    }

    /**
     * @return CurrencyRate|false
     */
    public function next()
    {
        return next($this->currencyRates);
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return (string) key($this->currencyRates);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->currencyRates) !== null;
    }


    public function rewind(): void
    {
        reset($this->currencyRates);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->currencyRates);
    }

    /**
     * @param string $symbolCode
     * @return CurrencyRate|null
     */
    public function getCurrencyRateBySymbolCode(string $symbolCode): ?CurrencyRate
    {
        return $this->currencyRates[$symbolCode] ?? null;
    }
}
