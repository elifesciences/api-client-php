<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

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
        return $this->getRequest('medium-articles?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc'),
            $headers);
    }
}
