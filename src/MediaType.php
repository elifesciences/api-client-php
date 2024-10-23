<?php

namespace eLife\ApiClient;

use Assert\Assertion;
use GuzzleHttp\Psr7\Header;

final class MediaType
{
    private $type;
    private $version;

    public function __construct(string $type, int $version)
    {
        Assertion::regex($type, '~^[\w.+-]+/[\w.+-]+$~', "'%s' is not a valid media type name");
        Assertion::min($version, 1, 'Version must be at least 1, got %s');

        $this->type = $type;
        $this->version = $version;
    }

    public static function fromString(string $header)
    {
        Assertion::notBlank($header, 'Media type is blank');

        $contentType = Header::parse($header)[0];

        Assertion::keyExists($contentType, 0, "'$header' is not a valid media type");
        Assertion::keyExists($contentType, 'version', "Media type '$header' is missing a version parameter");

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
