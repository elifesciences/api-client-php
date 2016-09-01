<?php

namespace eLife\ApiClient\ApiClient;

use eLife\ApiClient\ApiClient;
use GuzzleHttp\Promise\PromiseInterface;

final class ArticlesClient
{
    const TYPE_ARTICLE_POA = 'application/vnd.elife.article-poa+json';
    const TYPE_ARTICLE_VOR = 'application/vnd.elife.article-vor+json';
    const TYPE_ARTICLE_LIST = 'application/vnd.elife.articles-list+json';
    const TYPE_ARTICLE_HISTORY = 'application/vnd.elife.article-history+json';

    use ApiClient;

    public function getArticleLatestVersion(array $headers, string $number) : PromiseInterface
    {
        return $this->getRequest('articles/'.$number, $headers);
    }

    public function getArticleHistory(array $headers, string $number) : PromiseInterface
    {
        return $this->getRequest('articles/'.$number.'/versions', $headers);
    }

    public function getArticleVersion(array $headers, string $number, int $version) : PromiseInterface
    {
        return $this->getRequest('articles/'.$number.'/versions/'.$version, $headers);
    }

    public function listArticles(
        array $headers = [],
        int $page = 1,
        int $perPage = 20,
        bool $descendingOrder = true,
        array $subjects = []
    ) : PromiseInterface {
        $subjectQuery = '';
        foreach ($subjects as $subject) {
            $subjectQuery .= '&subject[]='.$subject;
        }

        return $this->getRequest(
            'articles?page='.$page.'&per-page='.$perPage.'&order='.($descendingOrder ? 'desc' : 'asc').$subjectQuery,
            $headers
        );
    }
}
