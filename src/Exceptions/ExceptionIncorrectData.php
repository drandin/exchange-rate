<?php

namespace CentralBankRussian\ExchangeRate\Exceptions;

use RuntimeException;
use Throwable;

/**
 * Class ExceptionIncorrectData
 * @package CentralBankRussian\ExchangeRate\Exceptions
 */
class ExceptionIncorrectData extends RuntimeException
{
    /**
     * ExceptionIncorrectData constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
