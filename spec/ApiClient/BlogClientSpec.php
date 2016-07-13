<?php

namespace spec\eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\HttpClient;
use eLife\ApiSdk\MediaType;
use eLife\ApiSdk\Result\ArrayResult;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class BlogClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient);
    }

    public function it_gets_an_article()
    {
        $request = new Request('GET', 'blog-articles/3',
            ['Accept' => 'application/vnd.elife.blog-article+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.blog-article+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->getArticle(2, '3')->shouldBeLike($response);
    }

    public function it_lists_articles()
    {
        $request = new Request('GET', 'blog-articles?page=1&per-page=20&order=desc&subject=cell-biology',
            ['Accept' => 'application/vnd.elife.blog-article-list+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.blog-article-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listArticles(2, 1, 20, true, 'cell-biology')->shouldBeLike($response);
    }
}
