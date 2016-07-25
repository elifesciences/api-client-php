<?php

namespace spec\eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\HttpClient;
use eLife\ApiSdk\MediaType;
use eLife\ApiSdk\Result\ArrayResult;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class SearchClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient);
    }

    public function it_queries()
    {
        $request = new Request('GET',
            'search?for=foo&page=1&per-page=20&sort=date&order=desc&subject[]=cell-biology&type[]=research-article',
            ['Accept' => 'application/vnd.elife.search+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.search+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->query(2, 'foo', 1, 20, 'date', true, ['cell-biology'], ['research-article'])->shouldBeLike($response);
    }
}
