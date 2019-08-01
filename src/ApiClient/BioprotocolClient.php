<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class BioprotocolClient
{
    const TYPE_BIOPROTOCOL = 'application/vnd.elife.bioprotocol+json';

    use ApiClient;

    public function list(
        array $headers,
        string $type,
        string $id
    ) : PromiseInterface {
        return $this->getRequest(
            $this->createUri([
                'path' => "bioprotocol/$type/$id"
            ]),
            $headers
        );
    }
}
