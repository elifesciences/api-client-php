<?php

namespace eLife\ApiSdk\ApiClient;

use eLife\ApiSdk\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class BlogClient
{
    const TYPE_BLOG_ARTICLE = 'application/vnd.elife.blog-article+json';
    const TYPE_BLOG_ARTICLE_LIST = 'application/vnd.elife.blog-article-list+json';

    use ApiClient;

    public function getArticle(array $headers, string $id) : PromiseInterface
    {
        return $this->getRequest('blog-articles/'.$id, $headers);
    }

    public function listArticles(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        string $subject = null
    ) : PromiseInterface {
        $subjectQuery = ('' !== trim($subject)) ? '&subject='.$subject : '';

        return $this->getRequest(
            'blog-articles?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery,
            $headers
        );
    }
}
