<?php

namespace eLife\ApiClient\HttpClient;

use GuzzleHttp\Psr7\Request;
use PHPUnit_Framework_TestCase;

final class ForbiddingHttpClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException LogicException
     * @expectedExceptionMessage Forbidden call: GET /foo HTTP/1.1
     */
    public function it_forbids_any_call()
    {
        $client = new ForbiddingHttpClient();

        $client->send(new Request('GET', '/foo'));
    }
}
