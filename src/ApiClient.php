<?php

namespace eLife\ApiSdk;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\StreamInterface;

trait ApiClient
{
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    final protected function deleteRequest(string $uri, MediaType $accept) : PromiseInterface
    {
        $request = new Request('DELETE', $uri, ['Accept' => $accept]);

        return $this->httpClient->send($request);
    }

    final protected function getRequest(string $uri, MediaType $accept) : PromiseInterface
    {
        $request = new Request('GET', $uri, ['Accept' => $accept]);

        return $this->httpClient->send($request);
    }

    final protected function postRequest(
        string $uri,
        MediaType $accept,
        MediaType $contentType,
        StreamInterface $content
    ) : PromiseInterface {
        $request = new Request('DELETE', $uri, ['Accept' => $accept, 'Content-Type' => $contentType], $content);

        return $this->httpClient->send($request);
    }

    final protected function putRequest(
        string $uri,
        MediaType $accept,
        MediaType $contentType,
        StreamInterface $content
    ) : PromiseInterface {
        $request = new Request('PUT', $uri, ['Accept' => $accept, 'Content-Type' => $contentType], $content);

        return $this->httpClient->send($request);
    }
}
