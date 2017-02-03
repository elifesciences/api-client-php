<?php

namespace spec\eLife\ApiClient\ApiClient;

use DateTimeImmutable;
use eLife\ApiClient\HttpClient;
use eLife\ApiClient\MediaType;
use eLife\ApiClient\Result\ArrayResult;
use eLife\ApiClient\Version;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class SearchClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient, ['X-Foo' => 'bar']);
    }

    public function it_queries()
    {
        $request = new Request('GET',
            'search?for=foo&page=1&per-page=20&sort=date&order=desc&subject[]=cell-biology&type[]=research-article&start-date=2017-01-02&end-date=2017-02-03',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.search+json; version=2', 'User-Agent' => 'eLifeApiClient/'.Version::get()]);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.search+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->query((['Accept' => 'application/vnd.elife.search+json; version=2']), 'foo', 1, 20, 'date', true,
            ['cell-biology'], ['research-article'], new DateTimeImmutable('2017-01-02'), new DateTimeImmutable('2017-02-03'))
            ->shouldBeLike($response)
        ;
    }
}
