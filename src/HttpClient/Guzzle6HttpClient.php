<?php

namespace eLife\ApiClient\HttpClient;

use Crell\ApiProblem\ApiProblem;
use Crell\ApiProblem\JsonParseException;
use eLife\ApiClient\Exception\ApiException;
use eLife\ApiClient\Exception\ApiProblemResponse;
use eLife\ApiClient\Exception\ApiTimeout;
use eLife\ApiClient\Exception\BadResponse;
use eLife\ApiClient\Exception\NetworkProblem;
use eLife\ApiClient\HttpClient;
use eLife\ApiClient\Result\HttpResult;
use GuzzleHttp\ClientInterface;
use function GuzzleHttp\default_user_agent;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Guzzle6HttpClient implements HttpClient
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function send(RequestInterface $request) : PromiseInterface
    {
        $request = $request->withHeader('User-Agent', trim(($request->getHeader('User-Agent')[0] ?? '').' '.default_user_agent()));

        return $this->client->sendAsync($request, ['http_errors' => true])
            ->then(
                function (ResponseInterface $response) {
                    return HttpResult::fromResponse($response);
                }
            )->otherwise(
                function ($reason) {
                    $e = Create::exceptionFor($reason);

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
                    } elseif ($e instanceof ConnectException && CURLE_OPERATION_TIMEOUTED === ($e->getHandlerContext()['errno'] ?? null)) {
                        throw new ApiTimeout($e->getMessage(), $e->getRequest(), $e);
                    } elseif ($e instanceof RequestException) {
                        throw new NetworkProblem($e->getMessage(), $e->getRequest(), $e);
                    }

                    throw new ApiException($e->getMessage(), $e);
                }
            );
    }
}
