<?php

namespace CentralBankRussian\ExchangeRate\Exceptions;

use RuntimeException;
use Throwable;

/**
 * Class ExceptionInvalidParameter
 * @package CentralBankRussian\ExchangeRate\Exceptions
 */
class ExceptionInvalidParameter extends RuntimeException
{
    /**
     * ExceptionInvalidParameter constructor.
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
