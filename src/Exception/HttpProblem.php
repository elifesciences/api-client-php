<?php

namespace eLife\ApiSdk\Exception;

use Exception;
use Psr\Http\Message\RequestInterface;

abstract class HttpProblem extends ApiException
{
    private $request;

    public function __construct(string $message, RequestInterface $request, Exception $previous = null)
    {
        parent::__construct($message, $previous);

        $this->request = $request;
    }

    final public function getRequest() : RequestInterface
    {
        return $this->request;
    }
}
