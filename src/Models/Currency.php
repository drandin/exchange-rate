<?php

namespace CentralBankRussian\ExchangeRate\Models;

/**
 * Class Currency
 * @package Drandin\ExchangeRate\Models
 */
final class Currency
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $nameEng = '';

    /**
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
     * @var string
     */
    private $internalCode = '';

    /**
     * @var string
     */
    private $internalCommonCode = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Currency
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameEng(): string
    {
        return $this->nameEng;
    }

    /**
     * @param string $nameEng
     * @return Currency
     */
    public function setNameEng(string $nameEng): Currency
    {
        $this->nameEng = $nameEng;
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
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity): Currency
    {
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
     * @param string $numericCode
     * @return Currency
     */
    public function setNumericCode(string $numericCode): Currency
    {
        $this->numericCode = $numericCode;
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
     * @param string $symbolCode
     * @return Currency
     */
    public function setSymbolCode(string $symbolCode): Currency
    {
        $this->symbolCode = $symbolCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getInternalCode(): string
    {
        return $this->internalCode;
    }

    /**
     * @param string $internalCode
     * @return Currency
     */
    public function setInternalCode(string $internalCode): Currency
    {
        $this->internalCode = $this->cleaner($internalCode);
        return $this;
    }

    /**
     * @return string
     */
    public function getInternalCommonCode(): string
    {
        return $this->internalCommonCode;
    }

    /**
     * @param string $internalCommonCode
     * @return Currency
     */
    public function setInternalCommonCode(string $internalCommonCode): Currency
    {
        $this->internalCommonCode = $this->cleaner($internalCommonCode);
        return $this;
    }

    /**
     * @param string $str
     * @return string
     */
    private function cleaner(string $str)
    {
        return trim(str_replace(' ', '', $str));
    }



}
