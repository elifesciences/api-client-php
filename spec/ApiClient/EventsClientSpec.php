<?php

namespace spec\eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\HttpClient;
use eLife\ApiSdk\MediaType;
use eLife\ApiSdk\Result\ArrayResult;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class EventsClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient, ['X-Foo' => 'bar']);
    }

    public function it_gets_an_event()
    {
        $request = new Request('GET', 'event/3',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.event+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.event+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->getEvent(['Accept' => 'application/vnd.elife.event+json; version=2'], 3)
            ->shouldBeLike($response);
    }

    public function it_lists_events()
    {
        $request = new Request('GET', 'events?page=1&per-page=20&type=open&order=desc',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.event-list+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.event-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listEvents(['Accept' => 'application/vnd.elife.event-list+json; version=2'], 1, 20, 'open', true)
            ->shouldBeLike($response);
    }
}
