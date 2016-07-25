<?php

namespace spec\eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\HttpClient;
use eLife\ApiSdk\MediaType;
use eLife\ApiSdk\Result\ArrayResult;
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
        $request = new Request('GET', 'medium-articles',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.medium-article-list+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.medium-article-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listArticles(['Accept' => 'application/vnd.elife.medium-article-list+json; version=2'])
            ->shouldBeLike($response)
        ;
    }
}
