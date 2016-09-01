<?php

namespace eLife\ApiClient\HttpClient;

use Crell\ApiProblem\ApiProblem;
use Crell\ApiProblem\JsonParseException;
use eLife\ApiClient\Exception\ApiException;
use eLife\ApiClient\Exception\ApiProblemResponse;
use eLife\ApiClient\Exception\BadResponse;
use eLife\ApiClient\Exception\NetworkProblem;
use eLife\ApiClient\HttpClient;
use eLife\ApiClient\Result\HttpResult;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

final class Guzzle6HttpClient implements HttpClient
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function send(RequestInterface $request) : PromiseInterface
    {
        return $this->client->sendAsync($request)
            ->then(
                function (ResponseInterface $response) {
                    return HttpResult::fromResponse($response);
                }
            )->otherwise(
                function (Throwable $e) {
                    if ($e instanceof BadResponseException) {
                        if ('application/problem+json' === $e->getResponse()->getHeaderLine('Content-Type')) {
                            try {
                                $apiProblem = ApiProblem::fromJson((string) $e->getResponse()->getBody());
                            } catch (JsonParseException $jsonE) {
                                throw new BadResponse($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
                            }
                            throw new ApiProblemResponse($apiProblem, $e->getRequest(), $e->getResponse(), $e);
                        } else {
                            throw new BadResponse($e->getMessage(), $e->getRequest(), $e->getResponse(), $e);
                        }
                    } elseif ($e instanceof RequestException) {
                        throw new NetworkProblem($e->getMessage(), $e->getRequest(), $e);
                    }

                    throw new ApiException($e->getMessage(), $e);
                }
            );
    }
}
