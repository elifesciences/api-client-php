<?php

namespace test\eLife\ApiClient;

use eLife\ApiClient\MediaType;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MediaTypeTest extends TestCase
{
    /**
     * @test
     * @dataProvider invalidMediaTypeProvider
     */
    public function it_throws_an_exception_when_a_media_type_is_invalid($mediaType, string $expectedException, string $expectedExceptionMessage)
    {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        new MediaType($mediaType, 1);
    }

    public function invalidMediaTypeProvider()
    {
        return [
            'empty string' => ['', InvalidArgumentException::class, "'' is not a valid media type"],
            'missing second part' => ['text', InvalidArgumentException::class, "'text' is not a valid media type"],
            'empty first part' => ['/json', InvalidArgumentException::class, "'/json' is not a valid media type"],
            'empty second part' => ['text/', InvalidArgumentException::class, "'text/' is not a valid media type"],
        ];
    }

    /**
     * @test
     * @dataProvider invalidVersionProvider
     */
    public function it_throws_an_exception_when_a_version_is_invalid($version, string $expectedException, string $expectedExceptionMessage)
    {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        new MediaType('application/json', $version);
    }

    public function invalidVersionProvider()
    {
        return [
            'negative number' => [-1, InvalidArgumentException::class, 'Version must be at least 1, got -1'],
            'zero' => [0, InvalidArgumentException::class, 'Version must be at least 1, got 0'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidStringProvider
     */
    public function it_throws_an_exception_when_a_string_input_is_invalid($string, string $expectedException, string $expectedExceptionMessage)
    {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        MediaType::fromString($string);
    }

    public function invalidStringProvider()
    {
        return [
            'empty string' => ['', InvalidArgumentException::class, 'Media type is blank'],
            'missing media type' => ['version=1', InvalidArgumentException::class, "'version=1' is not a valid media type"],
            'invalid media type' => ['application/; version=1', InvalidArgumentException::class, "'application/' is not a valid media type name"],
            'missing version' => ['application/vnd.elife.labs-post+json', InvalidArgumentException::class, "Media type 'application/vnd.elife.labs-post+json' is missing a version parameter"],
            'invalid version' => ['application/vnd.elife.labs-post+json; version=-1', InvalidArgumentException::class, 'Version must be at least 1, got -1'],
        ];
    }
}
