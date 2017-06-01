<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class HighlightsClient
{
    const TYPE_HIGHLIGHT_LIST = 'application/vnd.elife.highlight-list+json';

    use ApiClient;

    public function listHighlights(
        array $headers,
        string $id,
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => "highlights/$id",
                'query' => build_query(array_filter([
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                ])),
            ]),
            $headers
        );
    }
}
