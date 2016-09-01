<?php

namespace spec\eLife\ApiClient\ApiClient;

use eLife\ApiClient\HttpClient;
use eLife\ApiClient\MediaType;
use eLife\ApiClient\Result\ArrayResult;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Request;
use PhpSpec\ObjectBehavior;

final class LabsClientSpec extends ObjectBehavior
{
    private $httpClient;

    public function let(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->beConstructedWith($httpClient, ['X-Foo' => 'bar']);
    }

    public function it_gets_an_experiment()
    {
        $request = new Request('GET', 'labs-experiments/3',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.labs-experiment+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.labs-experiment+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->getExperiment(['Accept' => 'application/vnd.elife.labs-experiment+json; version=2'], 3)
            ->shouldBeLike($response)
        ;
    }

    public function it_lists_experiments()
    {
        $request = new Request('GET', 'labs-experiments?page=1&per-page=20&order=desc',
            ['X-Foo' => 'bar', 'Accept' => 'application/vnd.elife.labs-experiment-list+json; version=2']);
        $response = new FulfilledPromise(new ArrayResult(new MediaType('application/vnd.elife.labs-experiment-list+json',
            2), ['foo' => ['bar', 'baz']]));

        $this->httpClient->send($request)->willReturn($response);

        $this->listExperiments(['Accept' => 'application/vnd.elife.labs-experiment-list+json; version=2'])
            ->shouldBeLike($response)
        ;
    }
}
