<?php

namespace CentralBankRussian\ExchangeRate;

use CentralBankRussian\ExchangeRate\Collections\CurrencyCollection;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\Models\Currency;
use SimpleXMLElement;

/**
 * Class ReferenceData
 * @package Drandin\ExchangeRate
 */
final class ReferenceData
{
    /**
     * @var CBRClient
     */
    private $CBRClient;

    /**
     * ExchangeRate constructor.
     * @param CBRClient $CBRClient
     */
    public function __construct(CBRClient $CBRClient)
    {
        $this->CBRClient = $CBRClient;
    }

    /**
     * Перечень ежедневных валют
     *
     * @return CurrencyCollection
     * @throws ExceptionIncorrectData
     */
    public function getCurrencyCodesDaily(): CurrencyCollection
    {
        return $this->createCollection($this->CBRClient->getCurrencyCodesDaily());
    }

    /**
     * Перечень ежемесячных валют
     *
     * @return CurrencyCollection
     * @throws ExceptionIncorrectData
     */
    public function getCurrencyCodesMonthly(): CurrencyCollection
    {
        return $this->createCollection($this->CBRClient->getCurrencyCodesMonthly());
    }

    /**
     * @param $res
     * @return CurrencyCollection
     * @throws ExceptionIncorrectData
     */
    private function createCollection($res): CurrencyCollection
    {
        $currenciesElement = new SimpleXMLElement($res->EnumValutesResult->any);

        if (!isset($currenciesElement->ValuteData) || !isset($currenciesElement->ValuteData->EnumValutes)) {
            throw new ExceptionIncorrectData('There is no correct response to the request.');
        }

        $list = $currenciesElement->ValuteData->EnumValutes;

        if (empty($list)) {
            throw new ExceptionIncorrectData('Invalid data in the response. No list of currencies');
        }

        $currencyCollection = new CurrencyCollection;

        foreach ($list as $item) {

            /**
             * таблица содержит поля:
             * Vcode — Внутренний код валюты
             * Vname — Название валюты
             * VEngname — Англ. название валюты
             * Vnom — Номинал
             * VcommonCode — Внутренний код валюты, являющейся ’базовой’**
             * VnumCode — цифровой код ISO
             * VcharCode — 3х буквенный код ISO
             */

            if (empty($item)) {
                continue;
            }

            $symbolCode = (string) ($item->VcharCode ?? '');

            if ($symbolCode === '') {
                continue;
            }

            $currency = new Currency;

            $currency
                ->setInternalCode($item->Vcode ?? '')
                ->setName($item->Vname ?? '')
                ->setNameEng($item->VEngname ?? '')
                ->setQuantity((int) ($item->Vnom ?? 1))
                ->setInternalCommonCode($item->VcommonCode ?? '')
                ->setNumericCode($item->VnumCode ?? '')
                ->setSymbolCode($symbolCode);

            $currencyCollection->add($currency);
        }

        return $currencyCollection;
    }

}
