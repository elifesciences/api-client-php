<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class CommunityClient
{
    const TYPE_COMMUNITY_LIST = 'application/vnd.elife.community-list+json';

    use ApiClient;

    public function listContent(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        array $subjects = []
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'community',
                'query' => build_query([
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                    'subject[]' => $subjects,
                ]),
            ]),
            $headers
        );
    }
}
