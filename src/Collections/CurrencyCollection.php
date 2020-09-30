<?php

namespace CentralBankRussian\ExchangeRate\Collections;

use CentralBankRussian\ExchangeRate\Models\Currency;
use Iterator;

/**
 * Class CurrencyCollection
 *
 * @package Drandin\ExchangeRate\Collections
 */
class CurrencyCollection implements Iterator
{
    /**
     * @var array
     */
    private $currencies = [];

    /**
     * @param Currency $currency
     */
    public function add(Currency $currency)
    {
        $this->currencies[$currency->getSymbolCode()] = $currency;
    }

    /**
     * @return Currency|false
     */
    public function current()
    {
        return current($this->currencies);
    }

    /**
     * @return Currency|false
     */
    public function next()
    {
        return next($this->currencies);
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return (string) key($this->currencies);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->currencies) !== null;
    }


    public function rewind(): void
    {
        reset($this->currencies);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->currencies);
    }

    /**
     * @param string $symbolCode
     * @return Currency|null
     */
    public function getCurrencyBySymbolCode(string $symbolCode): ?Currency
    {
        return $this->currencies[$symbolCode] ?? null;
    }
}
