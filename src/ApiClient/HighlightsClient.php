<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class HighlightsClient
{
    const TYPE_HIGHLIGHT_LIST = 'application/vnd.elife.highlight-list+json';

    use ApiClient;

    public function listHighlights(
        array $headers = [],
        string $id,
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            'highlights/'.$id.'?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers
        );
    }
}
