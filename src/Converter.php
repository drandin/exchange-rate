<?php

namespace CentralBankRussian\ExchangeRate;

use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionInvalidParameter;
use DateTime;

/**
 * Class Converter
 * @package CentralBankRussian\ExchangeRate
 */
final class Converter
{
    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var ExchangeRate
     */
    private $exchangeRate;

    /**
     * @var int
     */
    private $precision = 2;

    /**
     * Converter constructor.
     *
     * @param ExchangeRate $exchangeRate
     */
    public function __construct(ExchangeRate $exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
        $this->date = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return Converter
     */
    public function setDate(DateTime $date): Converter
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param int $precision
     * @return $this
     * @throws ExceptionInvalidParameter
     */
    public function setPrecision(int $precision): Converter
    {
        if ($precision <= 0) {
            throw new ExceptionInvalidParameter('Precision must be greater than zero.');
        }

        $this->precision = $precision;
        return $this;
    }


    /**
     * @param float $val
     * @param string $symbolCodeFrom
     * @param string $symbolCodeTo
     * @return float
     * @throws ExceptionIncorrectData
     * @throws ExceptionInvalidParameter
     */
    public function convert(float $val, string $symbolCodeFrom, string $symbolCodeTo): float
    {
        if ($symbolCodeFrom === '' || $symbolCodeTo === '') {
            throw new ExceptionInvalidParameter('The currency code is incorrect.');
        }

        $symbolCodeFrom = mb_strtoupper($symbolCodeFrom);
        $symbolCodeTo = mb_strtoupper($symbolCodeTo);

        if ($symbolCodeFrom === $symbolCodeTo) {
            return $val;
        }

        $currencyRateCollection = $this->exchangeRate
            ->setDate($this->date)
            ->getCurrencyExchangeRates();

        if ($currencyRateCollection === null) {
            throw new ExceptionIncorrectData('Invalid data received.');
        }

        $currencyRateFrom = $currencyRateCollection->getCurrencyRateBySymbolCode($symbolCodeFrom);

        if ($currencyRateFrom === null) {
            throw new ExceptionInvalidParameter(
                'Could not find data for the currency code: '.$currencyRateFrom . '.'
            );
        }

        $currencyRateTo = $currencyRateCollection->getCurrencyRateBySymbolCode($symbolCodeTo);

        if ($currencyRateTo === null) {
            throw new ExceptionInvalidParameter(
                'Could not find data for the currency code: '.$currencyRateTo . '.'
            );
        }

        $exchangeRateFrom = $currencyRateFrom->getExchangeRate() / $currencyRateFrom->getQuantity();

        $exchangeRateTo = $currencyRateTo->getExchangeRate() / $currencyRateTo->getQuantity();

        $res = ($exchangeRateFrom / $exchangeRateTo) * $val;

        return round($res, $this->precision);
    }




}
