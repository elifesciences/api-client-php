<?php

namespace test\eLife\ApiClient\Result;

use eLife\ApiClient\Result\HttpResult;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TypeError;
use UnexpectedValueException;

final class HttpResultTest extends TestCase
{
    #[Test]
    public function it_requires_a_http_response()
    {
        $this->expectException(TypeError::class);

        HttpResult::fromResponse('foo');
    }

    #[Test]
    public function it_requires_a_media_type()
    {
        $this->expectException(UnexpectedValueException::class);

        HttpResult::fromResponse(new Response(200, [], json_encode(['foo' => ['bar', 'baz']])));
    }

    #[Test]
    public function it_requires_a_valid_media_type()
    {
        $this->expectException(UnexpectedValueException::class);

        HttpResult::fromResponse(new Response(200, ['Content-Type' => 'foo'], json_encode(['foo' => ['bar', 'baz']])));
    }

    #[Test]
    public function it_requires_data()
    {
        $this->expectException(UnexpectedValueException::class);

        HttpResult::fromResponse(new Response(200,
            ['Content-Type' => 'application/vnd.elife.labs-post+json; version=1']));
    }

    #[Test]
    public function it_requires_json_data()
    {
        $this->expectException(UnexpectedValueException::class);

        HttpResult::fromResponse(new Response(200,
            ['Content-Type' => 'application/vnd.elife.labs-post+json; version=1'], 'foo'));
    }
}
