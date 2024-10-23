<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\HttpClient;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use RuntimeException;

final class NotifyingHttpClientTest extends TestCase
{
    private $mock;
    private $guzzle;
    private $originalClient;
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalClient = $this->createMock(HttpClient::class);
        $this->client = new NotifyingHttpClient($this->originalClient);
    }

    /**
     * @test
     */
    public function it_allows_listeners_to_monitor_requests()
    {
        $request = new Request('GET', 'foo');
        $response = new Response(200);
        $this->originalClient->expects($this->once())
            ->method('send')
            ->with($request)
            ->will($this->returnValue(Create::promiseFor($response)));
        $this->sentRequests = [];
        $this->client->addRequestListener(function ($request) {
            $this->sentRequests[] = $request;
        });

        $this->client->send($request);

        $this->assertEquals([$request], $this->sentRequests);
    }

    /**
     * @test
     */
    public function it_does_not_propagate_errors_of_listeners()
    {
        $request = new Request('GET', 'foo');

        $this->client->addRequestListener(function ($request) {
            throw new RuntimeException('mocked error in listener');
        });

        $this->client->send($request);

        // This is to indicate that the test isn't risky.
        $this->assertTrue(true);
    }
}
