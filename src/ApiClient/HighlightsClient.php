<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class HighlightsClient
{
    const TYPE_HIGHLIGHTS = 'application/vnd.elife.highlights+json';

    use ApiClient;

    public function list(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest('highlights/'.$id, $headers);
    }
}
