<?php

namespace spec\eLife\ApiClient\ApiClient;

use eLife\ApiClient\HttpClient;
use eLife\ApiClient\MediaType;
use eLife\ApiClient\Result\ArrayResult;
use eLife\ApiClient\Version;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class RegionalCollectionsClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient, ['X-Foo' => 'bar']);
    }

    public function it_gets_a_regional_collection()
    {
        $request = new Request('GET', 'regional-collections/3',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.regional-collection+json; version=1', 'User-Agent' => 'eLifeApiClient/'.Version::get()]);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.regional-collection+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->getRegionalCollection(['Accept' => 'application/vnd.elife.regional-collection+json; version=1'], '3')
            ->shouldBeLike($response)
        ;
    }

    public function it_lists_regional_collections()
    {
        $request = new Request('GET', 'regional-collections?page=1&per-page=20&order=desc&subject[]=cell-biology&containing[]=article/1234&containing[]=interview/5678',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.regional-collection-list+json; version=1', 'User-Agent' => 'eLifeApiClient/'.Version::get()]);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.regional-collection-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listRegionalCollections(['Accept' => 'application/vnd.elife.regional-collection-list+json; version=1'],
            1, 20, true,
            ['cell-biology'], ['article/1234', 'interview/5678'])->shouldBeLike($response)
        ;
    }
}
