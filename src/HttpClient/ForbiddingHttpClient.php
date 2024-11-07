<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\Exception\UnintendedInteraction;
use eLife\ApiClient\HttpClient;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;

final class ForbiddingHttpClient implements HttpClient
{
    public function send(RequestInterface $request) : PromiseInterface
    {
        return Create::rejectionFor(new UnintendedInteraction('Forbidden call', $request));
    }
}
