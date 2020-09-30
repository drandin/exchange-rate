<?php

namespace CentralBankRussian\ExchangeRate;

use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionInvalidParameter;
use DateTime;
use CentralBankRussian\ExchangeRate\Collections\CurrencyRateCollection;
use CentralBankRussian\ExchangeRate\Models\CurrencyRate;
use SimpleXMLElement;

/**
 * Class ExchangeRate
 * @package Drandin\ExchangeRate
 */
final class ExchangeRate
{
    /**
     * @var CBRClient
     */
    private $CBRClient;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * ExchangeRate constructor.
     *
     * @param CBRClient $CBRClient
     */
    public function __construct(CBRClient $CBRClient)
    {
        $this->CBRClient = $CBRClient;
        $this->date = new DateTime();
    }

    /**
     * Возвращает коллекцию кусов валют
     *
     * @return CurrencyRateCollection
     * @throws ExceptionIncorrectData|Exceptions\ExceptionInvalidParameter
     */
    public function getCurrencyExchangeRates(): CurrencyRateCollection
    {
        $res = $this->CBRClient->getExchangeRate($this->date);

        if (!is_object($res)) {
            throw new ExceptionIncorrectData('There is no correct response to the request.');
        }

        $rates = new SimpleXMLElement($res->GetCursOnDateResult->any);

        if (!isset($rates->ValuteData) || !isset($rates->ValuteData->ValuteCursOnDate)) {
            throw new ExceptionIncorrectData('Invalid data in the response.');
        }

        $list = $rates->ValuteData->ValuteCursOnDate;

        $currencyRateCollection = new CurrencyRateCollection();

        foreach ($list as $rate) {

            /**
             * Название свойств объекта $rate
             *
             * Vname — Название валюты
             * Vnom — Номинал
             * Vcurs — Курс
             * Vcode — ISO Цифровой код валюты
             * VchCode — ISO Символьный код валюты
             */

            if (!$this->checkCurrencyRate($rate)) {
                continue;
            }

            $symbolCode = (string) ($rate->VchCode ?? '');

            $currencyRate = new CurrencyRate();

            $currencyRate
                ->setName($rate->Vname ?? '')
                ->setExchangeRate((float) ($rate->Vcurs ?? 0))
                ->setQuantity((int) ($rate->Vnom ?? 1))
                ->setNumericCode($rate->Vcode ?? '')
                ->setSymbolCode($symbolCode);

            $currencyRateCollection->add($currencyRate);

        }

        $currencyRateCollection->add($this->rub());

        return $currencyRateCollection;
    }

    /**
     * @param DateTime $date
     * @return $this
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param SimpleXMLElement $rate
     * @return bool
     */
    private function checkCurrencyRate(SimpleXMLElement $rate): bool
    {
        return !empty($rate->VchCode)
            && !empty($rate->Vnom)
            && !empty($rate->Vcode)
            && !empty($rate->Vcurs);
    }

    /**
     * @return CurrencyRate
     * @throws ExceptionInvalidParameter
     */
    private function rub(): CurrencyRate
    {
        return (new CurrencyRate())
            ->setName(CentralBankRussian::NAME_RUB)
            ->setExchangeRate(1)
            ->setQuantity(1)
            ->setNumericCode(CentralBankRussian::NUMERIC_CODE_RUB)
            ->setSymbolCode(CentralBankRussian::SYMBOL_CODE_RUB);
    }

    /**
     * Возвращает курс обмена валюты в рублях.
     *
     * @param string $symbolCode
     * @return float
     * @throws ExceptionIncorrectData|ExceptionInvalidParameter
     */
    public function getRateInRubles(string $symbolCode)
    {
        $symbolCode = strtoupper($symbolCode);

        $currencyRateCollection = $this->getCurrencyExchangeRates();

        $currencyRate = $currencyRateCollection->getCurrencyRateBySymbolCode($symbolCode);

        if ($currencyRate === null) {
            throw new ExceptionInvalidParameter('The currency code is incorrect.');
        }

        $value = $currencyRate->rateOneUnitInRubles();

        return (float) number_format($value, 4, '.','');
    }


}
