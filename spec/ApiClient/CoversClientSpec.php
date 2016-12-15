<?php

namespace spec\eLife\ApiClient\ApiClient;

use eLife\ApiClient\HttpClient;
use eLife\ApiClient\MediaType;
use eLife\ApiClient\Result\ArrayResult;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class CoversClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient, ['X-Foo' => 'bar']);
    }

    public function it_lists_covers()
    {
        $request = new Request('GET', 'covers?page=1&per-page=20&order=desc',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.cover-list+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.cover-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listCovers(['Accept' => 'application/vnd.elife.cover-list+json; version=2'], 1, 20, true)->shouldBeLike($response);
    }

    public function it_lists_current_covers()
    {
        $request = new Request('GET', 'covers/current',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.cover-list+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.cover-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listCurrentCovers(['Accept' => 'application/vnd.elife.cover-list+json; version=2'], 1, 20, true)->shouldBeLike($response);
    }
}
