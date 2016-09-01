<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class MediumClient
{
    const TYPE_MEDIUM_ARTICLE = 'application/vnd.elife.medium-article+json';
    const TYPE_MEDIUM_ARTICLE_LIST = 'application/vnd.elife.medium-article-list+json';

    use ApiClient;

    public function listArticles(array $headers = []) : PromiseInterface
    {
        return $this->getRequest('medium-articles', $headers);
    }
}
