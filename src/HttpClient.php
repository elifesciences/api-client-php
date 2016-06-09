<?php

namespace eLife\ApiSdk;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;

interface HttpClient
{
    public function send(RequestInterface $request) : PromiseInterface;
}
