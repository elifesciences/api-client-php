<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\HttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use LogicException;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Psr7\str;

final class ForbiddingHttpClient implements HttpClient
{
    public function send(RequestInterface $request) : PromiseInterface
    {
        throw new LogicException('Forbidden call: '.str($request));
    }
}
