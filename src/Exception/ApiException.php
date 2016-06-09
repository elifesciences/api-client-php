<?php

namespace eLife\ApiSdk\Exception;

use Exception;
use RuntimeException;

class ApiException extends RuntimeException
{
    public function __construct(string $message, Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
