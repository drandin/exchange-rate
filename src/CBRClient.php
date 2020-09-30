<?php

namespace CentralBankRussian\ExchangeRate;

use DateTime;
use SoapClient;
use SoapFault;

/**
 * Class CBRClient
 * @package Drandin\ExchangeRate\Models
 */
final class CBRClient
{
    /**
     * @var SoapClient
     */
    private $soapClient;

    /**
     * @var array|string[]
     */
    private $options = [
        'version' => 'SOAP_1_2'
    ];

    /**
     * Client constructor.
     *
     * CBRClient constructor.
     * @param array|null $options
     * @throws SoapFault
     */
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->options = $options;
        }

        $this->createSoapClient();
    }

    /**
     * @param DateTime $date
     * @return mixed
     */
    public function getExchangeRate(DateTime $date)
    {
        $method = CentralBankRussian::METHOD_GET_EXCHANGE_RATE;

        return $this->soapClient->$method([
            'On_date' => $date->format('Y-m-d')
        ]);
    }

    /**
     * Перечень ежедневных валют
     *
     * @return mixed
     */
    public function getCurrencyCodesDaily()
    {
        return $this->getCurrencyCodes(false);
    }

    /**
     * Перечень ежемесячных валют
     *
     * @return mixed
     */
    public function getCurrencyCodesMonthly()
    {
        return $this->getCurrencyCodes(true);
    }

    /**
     * @param bool $type
     * @return mixed
     */
    private function getCurrencyCodes(bool $type)
    {
        $method = CentralBankRussian::METHOD_GET_CURRENCY_CODES;

        return $this->soapClient->$method([
            'Seld' => $type
        ]);
    }

    /**
     * @return SoapClient
     * @throws SoapFault
     */
    private function createSoapClient(): SoapClient
    {
        if ($this->soapClient === null) {
            $this->soapClient = new SoapClient(CentralBankRussian::WSDL, [
                'version' => 'SOAP_1_2'
            ]);
        }

        return $this->soapClient;
    }

}
