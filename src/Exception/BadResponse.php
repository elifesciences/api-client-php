<?php

namespace eLife\ApiSdk\Exception;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BadResponse extends HttpProblem
{
    private $response;

    public function __construct(
        string $message,
        RequestInterface $request,
        ResponseInterface $response,
        Exception $previous = null
    ) {
        parent::__construct($message, $request, $previous);

        $this->response = $response;
    }

    final public function getResponse() : ResponseInterface
    {
        return $this->response;
    }
}
