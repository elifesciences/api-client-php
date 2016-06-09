<?php

namespace eLife\ApiSdk;

use Assert\Assertion;
use function GuzzleHttp\Psr7\parse_header;

final class MediaType
{
    private $type;
    private $version;

    public function __construct(string $type, int $version)
    {
        Assertion::regex($type, '~^[\w.+-]+/[\w.+-]+$~');
        Assertion::min($version, 1);

        $this->type = $type;
        $this->version = $version;
    }

    public static function fromString(string $header)
    {
        Assertion::notBlank($header);

        $contentType = parse_header($header)[0];

        Assertion::keyExists($contentType, 0);
        Assertion::keyExists($contentType, 'version');

        return new self($contentType[0], $contentType['version']);
    }

    public function __toString() : string
    {
        return $this->type.'; version='.$this->version;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getVersion() : int
    {
        return $this->version;
    }
}
