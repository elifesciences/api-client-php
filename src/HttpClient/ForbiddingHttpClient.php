<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\Exception\UnintendedInteraction;
use eLife\ApiClient\HttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use function GuzzleHttp\Promise\rejection_for;

final class ForbiddingHttpClient implements HttpClient
{
    public function send(RequestInterface $request) : PromiseInterface
    {
        return rejection_for(new UnintendedInteraction('Forbidden call', $request));
    }
}
