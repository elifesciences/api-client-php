<?php

namespace test\eLife\ApiClient;

use eLife\ApiClient\MediaType;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use TypeError;

final class MediaTypeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider invalidMediaTypeProvider
     */
    public function it_throws_an_exception_when_a_media_type_is_invalid($mediaType, string $expectedException)
    {
        $this->expectException($expectedException);

        new MediaType($mediaType, 1);
    }

    public function invalidMediaTypeProvider()
    {
        return [
            'not a string' => [null, TypeError::class],
            'empty string' => ['', InvalidArgumentException::class],
            'missing second part' => ['text', InvalidArgumentException::class],
            'empty first part' => ['/json', InvalidArgumentException::class],
            'empty second part' => ['text/', InvalidArgumentException::class],
        ];
    }

    /**
     * @test
     * @dataProvider invalidVersionProvider
     */
    public function it_throws_an_exception_when_a_version_is_invalid($version, string $expectedException)
    {
        $this->expectException($expectedException);

        new MediaType('application/json', $version);
    }

    public function invalidVersionProvider()
    {
        return [
            'not an integer' => [null, TypeError::class],
            'negative number' => [-1, InvalidArgumentException::class],
            'zero' => [0, InvalidArgumentException::class],
        ];
    }

    /**
     * @test
     * @dataProvider invalidStringProvider
     */
    public function it_throws_an_exception_when_a_string_input_is_invalid($string, string $expectedException)
    {
        $this->expectException($expectedException);

        MediaType::fromString($string);
    }

    public function invalidStringProvider()
    {
        return [
            'not a string' => [null, TypeError::class],
            'empty string' => ['', InvalidArgumentException::class],
            'missing media type' => ['version=1', InvalidArgumentException::class],
            'invalid media type' => ['application/; version=1', InvalidArgumentException::class],
            'missing version' => ['application/vnd.elife.labs-experiment+json', InvalidArgumentException::class],
            'invalid version' => ['application/vnd.elife.labs-experiment+json; version=-1', InvalidArgumentException::class],
        ];
    }
}
