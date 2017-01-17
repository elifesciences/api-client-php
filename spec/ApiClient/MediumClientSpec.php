<?php

namespace spec\eLife\ApiClient\ApiClient;

use eLife\ApiClient\HttpClient;
use eLife\ApiClient\MediaType;
use eLife\ApiClient\Result\ArrayResult;
use eLife\ApiClient\Version;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class MediumClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient, ['X-Foo' => 'bar']);
    }

    public function it_lists_medium_articles()
    {
        $request = new Request('GET', 'medium-articles?page=1&per-page=20&order=desc',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.medium-article-list+json; version=2', 'User-Agent' => 'eLifeApiClient/'.Version::get()]);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.medium-article-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listArticles(['Accept' => 'application/vnd.elife.medium-article-list+json; version=2'])
            ->shouldBeLike($response)
        ;
    }
}
