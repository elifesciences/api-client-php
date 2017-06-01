<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\build_query;

final class MediumClient
{
    const TYPE_MEDIUM_ARTICLE = 'application/vnd.elife.medium-article+json';
    const TYPE_MEDIUM_ARTICLE_LIST = 'application/vnd.elife.medium-article-list+json';

    use ApiClient;

    public function listArticles(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true
    ) : PromiseInterface {
        return $this->getRequest(
            Uri::fromParts([
                'path' => 'medium-articles',
                'query' => build_query([
                    'page' => $page,
                    'per-page' => $perPage,
                    'order' => $descendingOrder ? 'desc' : 'asc',
                ]),
            ]),
            $headers);
    }
}
