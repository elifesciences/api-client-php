<?php

namespace eLife\ApiClient\HttpClient;

use Crell\ApiProblem\ApiProblem;
use eLife\ApiClient\Exception\ApiException;
use eLife\ApiClient\Exception\ApiProblemResponse;
use eLife\ApiClient\Exception\BadResponse;
use eLife\ApiClient\Exception\NetworkProblem;
use eLife\ApiClient\Result\HttpResult;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use RuntimeException;

final class Guzzle6HttpClientTest extends PHPUnit_Framework_TestCase
{
    private $mock;
    private $guzzle;

    protected function setUp()
    {
        parent::setUp();

        $this->mock = new MockHandler();
        $this->guzzle = new Client(['handler' => HandlerStack::create($this->mock)]);
    }

    /**
     * @test
     */
    public function it_returns_results()
    {
        $request = new Request('GET', 'foo');
        $response = new Response(200, ['Content-Type' => 'application/vnd.elife.labs-experiment+json; version=1'],
            json_encode(['foo' => ['bar', 'baz']]));
        $result = HttpResult::fromResponse($response);

        $this->mock->append($response);

        $client = new Guzzle6HttpClient($this->guzzle);

        $this->assertEquals($result, $client->send($request)->wait());
    }

    /**
     * @test
     */
    public function it_throws_api_problems()
    {
        $request = new Request('GET', 'foo');
        $apiProblem = new ApiProblem('Problem');
        $response = new Response(404, ['Content-Type' => 'application/problem+json'], $apiProblem->asJson());

        $this->mock->append($response);

        $client = new Guzzle6HttpClient($this->guzzle);

        $this->expectException(ApiProblemResponse::class);

        $client->send($request)->wait();
    }

    /**
     * @test
     */
    public function it_throws_response_exceptions_on_broken_api_problems()
    {
        $request = new Request('GET', 'foo');
        $response = new Response(404, ['Content-Type' => 'application/problem+json'], 'foo bar baz');

        $this->mock->append($response);

        $client = new Guzzle6HttpClient($this->guzzle);

        $this->expectException(BadResponse::class);

        $client->send($request)->wait();
    }

    /**
     * @test
     */
    public function it_throws_response_exceptions()
    {
        $request = new Request('GET', 'foo');
        $apiProblem = new ApiProblem('Problem');
        $response = new Response(404, ['Content-Type' => 'foo/bar'], $apiProblem->asJson());

        $this->mock->append($response);

        $client = new Guzzle6HttpClient($this->guzzle);

        $this->expectException(BadResponse::class);

        $client->send($request)->wait();
    }

    /**
     * @test
     */
    public function it_throws_network_exceptions()
    {
        $request = new Request('GET', 'foo');
        $this->mock->append(new RequestException('Problem', $request));

        $client = new Guzzle6HttpClient($this->guzzle);

        $this->expectException(NetworkProblem::class);

        $client->send($request)->wait();
    }

    /**
     * @test
     */
    public function it_throws_api_exceptions()
    {
        $request = new Request('GET', 'foo');
        $this->mock->append(new TransferException());

        $client = new Guzzle6HttpClient($this->guzzle);

        $this->expectException(ApiException::class);

        $client->send($request)->wait();
    }

    /**
     * @test
     */
    public function it_allows_listeners_to_monitor_requests()
    {
        $request = new Request('GET', 'foo');
        $response = new Response(200);
        $this->mock->append($response);
        $client = new Guzzle6HttpClient($this->guzzle);

        $this->sentRequests = [];
        $client->addRequestListener(function($request) {
            $this->sentRequests[] = $request;
        });

        $client->send($request);

        $this->assertEquals([$request], $this->sentRequests);
    }

    /**
     * @test
     */
    public function it_does_not_propagate_errors_of_listeners()
    {
        $request = new Request('GET', 'foo');
        $client = new Guzzle6HttpClient($this->guzzle);

        $client->addRequestListener(function($request) {
            throw new RuntimeException("mocked error in listener");
        });

        $client->send($request);
    }
}
