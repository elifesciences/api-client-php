<?php

namespace eLife\ApiClient\Exception;

use Crell\ApiProblem\ApiProblem;
use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiProblemResponse extends BadResponse
{
    private $apiProblem;

    public function __construct(
        ApiProblem $apiProblem,
        RequestInterface $request,
        ResponseInterface $response,
        Exception $previous = null
    ) {
        parent::__construct((string) $apiProblem->getTitle(), $request, $response, $previous);

        $this->apiProblem = $apiProblem;
    }

    final public function getApiProblem() : ApiProblem
    {
        return $this->apiProblem;
    }
}
