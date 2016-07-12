<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use eLife\ApiSdk\MediaType;
use GuzzleHttp\Promise\PromiseInterface;

final class MediumClient
{
    use ApiClient;

    public function listArticles(int $version) : PromiseInterface
    {
        return $this->getRequest(
            'medium-articles',
            new MediaType('application/vnd.elife.medium-article-list+json', $version)
        );
    }
}
