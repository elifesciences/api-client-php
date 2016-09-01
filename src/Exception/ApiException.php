<?php

namespace eLife\ApiClient\Exception;

use Exception;
use RuntimeException;

/**
 * @SuppressWarnings(ForbiddenExceptionSuffix)
 */
class ApiException extends RuntimeException
{
    public function __construct(string $message, Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
