<?php

namespace eLife\ApiClient\HttpClient;

use eLife\ApiClient\Exception\UnintendedInteraction;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

final class ForbiddingHttpClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_forbids_any_call()
    {
        $client = new ForbiddingHttpClient();
        $request = new Request('GET', '/foo');

        $this->expectException(UnintendedInteraction::class);
        $this->expectExceptionMessage('Forbidden call');

        $client->send($request)->wait();
    }
}
