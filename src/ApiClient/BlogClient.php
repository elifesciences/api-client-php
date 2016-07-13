<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use eLife\ApiSdk\MediaType;
use GuzzleHttp\Promise\PromiseInterface;

final class BlogClient
{
    use ApiClient;

    public function getArticle(int $version, string $id) : PromiseInterface
    {
        return $this->getRequest(
            'blog-articles/'.$id,
            new MediaType('application/vnd.elife.blog-article+json', $version)
        );
    }

    public function listArticles(
        int $version,
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        string $subject = null
    ) : PromiseInterface {
        $subjectQuery = ('' !== trim($subject)) ? '&subject='.$subject : '';

        return $this->getRequest(
            'blog-articles?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery,
            new MediaType('application/vnd.elife.blog-article-list+json', $version)
        );
    }
}
