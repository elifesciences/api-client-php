<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\Exception\UnintendedInteraction;
use eLife\ApiClient\HttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use function GuzzleHttp\Promise\rejection_for;
use Psr\Http\Message\RequestInterface;

final class ForbiddingHttpClient implements HttpClient
{
    public function send(RequestInterface $request) : PromiseInterface
    {
        return rejection_for(new UnintendedInteraction('Forbidden call', $request));
    }
}
