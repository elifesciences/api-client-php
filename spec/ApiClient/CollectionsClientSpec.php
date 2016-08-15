<?php

namespace spec\eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\HttpClient;
use eLife\ApiSdk\MediaType;
use eLife\ApiSdk\Result\ArrayResult;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class CollectionsClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient, ['X-Foo' => 'bar']);
    }

    public function it_gets_a_collection()
    {
        $request = new Request('GET', 'collections/3',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.collection+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.collection+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->getCollection(['Accept' => 'application/vnd.elife.collection+json; version=2'], '3')
            ->shouldBeLike($response)
        ;
    }

    public function it_lists_collections()
    {
        $request = new Request('GET', 'collections?page=1&per-page=20&order=desc&subject=cell-biology',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.collection-list+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.collection-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listCollections(['Accept' => 'application/vnd.elife.collection-list+json; version=2'],
            1, 20, true,
            'cell-biology')->shouldBeLike($response)
        ;
    }
}
