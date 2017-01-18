<?php

namespace eLife\ApiClient;

use eLife\ApiClient\HttpClient\UserAgentPrependingHttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\StreamInterface;

trait ApiClient
{
    private $httpClient;
    private $headers;

    public function __construct(HttpClient $httpClient, array $headers = [])
    {
        $this->httpClient = new UserAgentPrependingHttpClient($httpClient, 'eLifeApiClient/'.Version::get());
        $this->headers = $headers;
    }

    final protected function deleteRequest(string $uri, array $headers) : PromiseInterface
    {
        $request = new Request('DELETE', $uri, array_merge($this->headers, $headers));

        return $this->httpClient->send($request);
    }

    final protected function getRequest(string $uri, array $headers) : PromiseInterface
    {
        $request = new Request('GET', $uri, array_merge($this->headers, $headers));

        return $this->httpClient->send($request);
    }

    final protected function postRequest(
        string $uri,
        array $headers,
        MediaType $contentType,
        StreamInterface $content
    ) : PromiseInterface {
        $headers = array_merge($this->headers, $headers, ['Content-Type' => $contentType]);

        $request = new Request('DELETE', $uri, $headers, $content);

        return $this->httpClient->send($request);
    }

    final protected function putRequest(
        string $uri,
        array $headers,
        MediaType $contentType,
        StreamInterface $content
    ) : PromiseInterface {
        $headers = array_merge($this->headers, $headers, ['Content-Type' => $contentType]);

        $request = new Request('PUT', $uri, $headers, $content);

        return $this->httpClient->send($request);
    }
}
