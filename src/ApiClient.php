<?php

namespace eLife\ApiClient;

use eLife\ApiClient\HttpClient\UserAgentPrependingHttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

trait ApiClient
{
    private $httpClient;
    private $headers;

    public function __construct(HttpClient $httpClient, array $headers = [])
    {
        $this->httpClient = new UserAgentPrependingHttpClient($httpClient, 'eLifeApiClient/'.Version::get());
        $this->headers = $headers;
    }

    final protected function deleteRequest(UriInterface $uri, array $headers) : PromiseInterface
    {
        $request = new Request('DELETE', $uri, array_merge($this->headers, $headers));

        return $this->httpClient->send($request);
    }

    final protected function getRequest(UriInterface $uri, array $headers) : PromiseInterface
    {
        $request = new Request('GET', $uri, array_merge($this->headers, $headers));

        return $this->httpClient->send($request);
    }

    final protected function postRequest(
        UriInterface $uri,
        array $headers,
        MediaType $contentType,
        StreamInterface $content
    ) : PromiseInterface {
        $headers = array_merge($this->headers, $headers, ['Content-Type' => $contentType]);

        $request = new Request('DELETE', $uri, $headers, $content);

        return $this->httpClient->send($request);
    }

    final protected function putRequest(
        UriInterface $uri,
        array $headers,
        MediaType $contentType,
        StreamInterface $content
    ) : PromiseInterface {
        $headers = array_merge($this->headers, $headers, ['Content-Type' => $contentType]);

        $request = new Request('PUT', $uri, $headers, $content);

        return $this->httpClient->send($request);
    }
}
