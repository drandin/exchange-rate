<?php

namespace CentralBankRussian\ExchangeRate;

/**
 * Class CentralBankRussian
 * @package Drandin\ExchangeRate
 */
abstract class CentralBankRussian
{
    public const WSDL = 'https://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL';

    /**
     * Числовой код валюты «Рубль»
     */
    public const NUMERIC_CODE_RUB = '643';

    /**
     * Символьный код валюты «Рубль»
     */
    public const SYMBOL_CODE_RUB = 'RUB';

    /**
     * Название российской валюты
     */
    public const NAME_RUB = 'Российский рубль';

    /**
     * GetCursOnDate(On_date) получение курсов валют
     * на определенную дату (ежедневные курсы валют)
     *
     * @url https://www.cbr.ru/development/DWS/
     */
    public const METHOD_GET_EXCHANGE_RATE = 'GetCursOnDate';

    /**
     * EnumValutes(Seld) Справочник по кодам валют,
     * содержит полный перечень валют котируемых Банком России.
     *
     * @url https://www.cbr.ru/development/DWS/
     */
    public const METHOD_GET_CURRENCY_CODES = 'EnumValutes';
}
