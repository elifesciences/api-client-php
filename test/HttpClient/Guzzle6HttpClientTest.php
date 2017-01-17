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
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use Traversable;
use function GuzzleHttp\default_user_agent;

final class Guzzle6HttpClientTest extends PHPUnit_Framework_TestCase
{
    private $mock;
    private $history;
    private $guzzle;

    protected function setUp()
    {
        parent::setUp();

        $this->mock = new MockHandler();
        $this->history = [];

        $stack = HandlerStack::create($this->mock);
        $stack->push(Middleware::history($this->history));

        $this->guzzle = new Client(['handler' => $stack]);
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
     * @dataProvider userAgentProvider
     */
    public function it_sets_a_user_agent(string $existing = null, string $expected)
    {
        $request = new Request('GET', 'foo', ['User-Agent' => $existing]);
        $response = new Response(200, ['Content-Type' => 'application/vnd.elife.labs-experiment+json; version=1'],
            json_encode(['foo' => ['bar', 'baz']]));

        $this->mock->append($response);

        $client = new Guzzle6HttpClient($this->guzzle);

        $client->send($request)->wait();

        $this->assertSame($expected, $this->history[0]['request']->getHeaderLine('User-Agent'));
    }

    public function userAgentProvider() : Traversable
    {
        yield 'sets when empty' => [null, default_user_agent()];
        yield 'appends to existing' => ['bar', sprintf('bar %s', default_user_agent())];
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
}
