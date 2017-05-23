<?php

namespace test\eLife\ApiClient\Result;

use eLife\ApiClient\Result\HttpResult;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use TypeError;
use UnexpectedValueException;

final class HttpResultTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_requires_a_http_response()
    {
        $this->expectException(TypeError::class);

        HttpResult::fromResponse('foo');
    }

    /**
     * @test
     */
    public function it_requires_a_media_type()
    {
        $this->expectException(UnexpectedValueException::class);

        HttpResult::fromResponse(new Response(200, [], json_encode(['foo' => ['bar', 'baz']])));
    }

    /**
     * @test
     */
    public function it_requires_a_valid_media_type()
    {
        $this->expectException(UnexpectedValueException::class);

        HttpResult::fromResponse(new Response(200, ['Content-Type' => 'foo'], json_encode(['foo' => ['bar', 'baz']])));
    }

    /**
     * @test
     */
    public function it_requires_data()
    {
        $this->expectException(UnexpectedValueException::class);

        HttpResult::fromResponse(new Response(200,
            ['Content-Type' => 'application/vnd.elife.labs-post+json; version=1']));
    }

    /**
     * @test
     */
    public function it_requires_json_data()
    {
        $this->expectException(UnexpectedValueException::class);

        HttpResult::fromResponse(new Response(200,
            ['Content-Type' => 'application/vnd.elife.labs-post+json; version=1'], 'foo'));
    }
}
