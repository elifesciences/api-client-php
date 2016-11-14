<?php

namespace eLife\ApiClient\HttpClient;

use GuzzleHttp\Psr7\Request;
use LogicException;
use PHPUnit_Framework_TestCase;

final class ForbiddingHttpClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_forbids_any_call()
    {
        $client = new ForbiddingHttpClient();
        $request = new Request('GET', '/foo');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Forbidden call: GET /foo HTTP/1.1');

        $client->send($request);
    }
}
