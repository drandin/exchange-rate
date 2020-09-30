<?php

namespace CentralBankRussian\ExchangeRate\Models;

use CentralBankRussian\ExchangeRate\Exceptions\ExceptionInvalidParameter;

/**
 * Class CurrencyRate
 * @package Drandin\ExchangeRate\Models
 */
final class CurrencyRate
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * Обменный курс валюты
     * в количестве $this->$quantity в рублях
     *
     * @var float
     */
    private $exchangeRate = 1;

    /**
     * Количество (номинал)
     *
     * @var int
     */
    private $quantity = 1;

    /**
     * ISO Цифровой код валюты
     *
     * @var string
     */
    private $numericCode = '';

    /**
     * ISO Символьный код валюты
     *
     * @var string
     */
    private $symbolCode = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Название валюты
     *
     * @param string $name
     * @return CurrencyRate
     */
    public function setName(string $name): CurrencyRate
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }

    /**
     * Курс валюты
     *
     * @param float $exchangeRate
     * @return CurrencyRate
     */
    public function setExchangeRate(float $exchangeRate): CurrencyRate
    {
        $this->exchangeRate = $exchangeRate;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Количество (номинал)
     *
     * @param int $quantity
     * @return CurrencyRate
     * @throws ExceptionInvalidParameter
     */
    public function setQuantity(int $quantity): CurrencyRate
    {
        if ($quantity <= 0) {
            throw new ExceptionInvalidParameter('The quantity cannot be negative.');
        }

        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumericCode(): string
    {
        return $this->numericCode;
    }

    /**
     * ISO Цифровой код валюты
     *
     * @param string $numericCode
     * @return CurrencyRate
     */
    public function setNumericCode(string $numericCode): CurrencyRate
    {
        $this->numericCode = trim($numericCode);
        return $this;
    }

    /**
     * @return string
     */
    public function getSymbolCode(): string
    {
        return $this->symbolCode;
    }

    /**
     * ISO Символьный код валюты
     *
     * @param string $symbolCode
     * @return CurrencyRate
     */
    public function setSymbolCode(string $symbolCode): CurrencyRate
    {
        $this->symbolCode = $symbolCode;
        return $this;
    }


    /**
     * Возвращает курс обмена валюты в рублях.
     *
     * @return float
     */
    public function rateOneUnitInRubles(): float
    {
        $value = ($this->getExchangeRate() / $this->getQuantity());
        return (float) number_format($value, 4, '.','');
    }


}
