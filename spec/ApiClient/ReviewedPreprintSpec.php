<?php

namespace spec\eLife\ApiClient\ApiClient;

use eLife\ApiClient\HttpClient;
use eLife\ApiClient\MediaType;
use eLife\ApiClient\Result\ArrayResult;
use eLife\ApiClient\Version;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class ReviewedPreprintSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient, ['X-Foo' => 'bar']);
    }

    public function it_gets_a_reviewed_preprint()
    {
        $request = new Request('GET', 'reviewed-preprint/3',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.reviewed-preprint+json; version=1', 'User-Agent' => 'eLifeApiClient/'.Version::get()]);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.reviewed-preprint+json',
            1), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->getReviewedPreprint(['Accept' => 'application/vnd.elife.reviewed-preprint+json; version=1'], '3')
            ->shouldBeLike($response)
        ;
    }

    public function it_lists_reviewed_preprint()
    {
        $request = new Request('GET', 'reviewed-preprint?page=1&per-page=20&order=desc',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.reviewed-preprint-list+json; version=1', 'User-Agent' => 'eLifeApiClient/'.Version::get()]);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.reviewed-preprint-list+json',
            1), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listReviewedPreprint(['Accept' => 'application/vnd.elife.reviewed-preprint-list+json; version=1'],
            1, 20, true)->shouldBeLike($response)
        ;
    }
}
