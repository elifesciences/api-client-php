<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
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
